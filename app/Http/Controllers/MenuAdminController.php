<?php

namespace App\Http\Controllers;

use App\Models\Pagina;
use App\Models\SiteMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laracasts\Flash\Flash;

class MenuAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Session::put('url', 'menus');

        $menus = SiteMenu::with(['pagina', 'filhos.pagina', 'filhos.filhos.pagina'])
            ->where(function ($q) {
                $q->whereNull('id_pai')->orWhere('id_pai', 0);
            })
            ->ordenados()
            ->get();

        $total = SiteMenu::count();
        $ativos = SiteMenu::where('fl_ativo', 1)->count();
        $comPagina = SiteMenu::whereNotNull('id_pagina')->count();
        $comLink = SiteMenu::whereNull('id_pagina')->whereNotNull('url')->where('url', '!=', '')->count();

        $resumo = [
            'total' => $total,
            'ativos' => $ativos,
            'inativos' => $total - $ativos,
            'com_pagina' => $comPagina,
            'com_link' => $comLink,
        ];

        return view('gercont/menus', compact('menus', 'resumo'));
    }

    public function create()
    {
        Session::put('url', 'menus');

        return view('menu_admin/create', $this->formData());
    }

    public function store(Request $request)
    {
        $dados = $this->validar($request);
        $menu = new SiteMenu($dados);
        $menu->save();

        Flash::success('<i class="fa fa-check"></i> Menu <strong>' . e($menu->descricao) . '</strong> cadastrado.');

        return redirect('gercont/menus');
    }

    public function edit($id)
    {
        Session::put('url', 'menus');

        $menu = SiteMenu::findOrFail($id);

        return view('menu_admin/edit', array_merge($this->formData($menu->id), compact('menu')));
    }

    public function update(Request $request, $id)
    {
        $menu = SiteMenu::findOrFail($id);
        $dados = $this->validar($request, $menu);
        $menu->fill($dados);
        $menu->save();

        Flash::success('<i class="fa fa-check"></i> Menu <strong>' . e($menu->descricao) . '</strong> atualizado.');

        return redirect('gercont/menus');
    }

    public function toggleAtivo($id)
    {
        $menu = SiteMenu::findOrFail($id);
        $menu->fl_ativo = $menu->fl_ativo ? 0 : 1;
        $menu->save();

        Flash::success(
            '<i class="fa fa-check"></i> Menu <strong>' . e($menu->descricao) . '</strong> '
            . ($menu->fl_ativo ? 'ativado' : 'desativado') . '.'
        );

        return redirect('gercont/menus');
    }

    public function destroy($id)
    {
        $menu = SiteMenu::findOrFail($id);

        if ($menu->filhos()->exists()) {
            Flash::warning(
                '<i class="fa fa-warning"></i> Não é possível excluir <strong>' . e($menu->descricao)
                . '</strong>: existem submenus vinculados. Remova ou reatribua os filhos antes.'
            );

            return redirect('gercont/menus');
        }

        $descricao = $menu->descricao;
        $menu->delete();

        Flash::success('<i class="fa fa-check"></i> Menu <strong>' . e($descricao) . '</strong> excluído.');

        return redirect('gercont/menus');
    }

    private function formData(?int $excetoId = null): array
    {
        $pais = SiteMenu::ordenados()
            ->when($excetoId, function ($q) use ($excetoId) {
                $q->where('id', '!=', $excetoId);
            })
            ->get(['id', 'descricao', 'id_pai']);

        $paginas = Pagina::orderBy('titulo')
            ->get(['id', 'titulo', 'apelido', 'fl_publicacao']);

        return compact('pais', 'paginas');
    }

    private function validar(Request $request, ?SiteMenu $menu = null): array
    {
        $id = $menu ? $menu->id : null;

        $request->validate([
            'descricao' => 'required|min:2|max:100',
            'apelido' => 'nullable|max:100',
            'url' => 'nullable|max:500',
            'id_pagina' => ['nullable', 'integer', Rule::exists('pagina', 'id')],
            'id_pai' => [
                'nullable',
                'integer',
                Rule::exists('site_menu', 'id'),
                Rule::notIn($id ? [$id] : []),
            ],
            'ordem' => 'nullable|integer|min:0|max:9999',
            'fl_ativo' => 'nullable',
        ], [
            'descricao.required' => 'Informe a descrição do menu.',
            'id_pagina.exists' => 'A página selecionada não existe.',
            'id_pai.exists' => 'O menu pai selecionado não existe.',
            'id_pai.not_in' => 'Um menu não pode ser pai de si mesmo.',
        ]);

        $idPai = $request->filled('id_pai') ? (int) $request->id_pai : null;
        $idPagina = $request->filled('id_pagina') ? (int) $request->id_pagina : null;
        $url = trim((string) $request->input('url', ''));
        $url = $url !== '' ? $url : null;

        if ($idPagina && !$url) {
            $pagina = Pagina::find($idPagina);
            if ($pagina) {
                $url = 'pagina/' . $pagina->apelido;
            }
        }

        $apelido = trim((string) $request->input('apelido', ''));
        if ($apelido === '') {
            $apelido = Str::slug($request->descricao) ?: null;
        }

        return [
            'descricao' => trim($request->descricao),
            'apelido' => $apelido,
            'url' => $url,
            'id_pagina' => $idPagina,
            'id_pai' => $idPai,
            'fl_pai' => $idPai ? 0 : 1,
            'fl_ativo' => $request->has('fl_ativo') ? 1 : 0,
            'ordem' => (int) ($request->input('ordem') ?: 0),
        ];
    }
}
