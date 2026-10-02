<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Support\Cpf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laracasts\Flash\Flash;

class AssociadoAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Session::put('url', 'associados');

        $associados = Associado::orderBy('nome')->get();
        $limite = Carbon::now()->subDays(30);

        $resumo = [
            'total' => $associados->count(),
            'ativos' => $associados->where('fl_ativo', true)->count(),
            'sem_senha' => $associados->filter(function ($a) { return !$a->temSenha(); })->count(),
            'site' => $associados->where('origem', Associado::ORIGEM_SITE)->count(),
            'novos' => $associados->filter(function ($a) use ($limite) { return $a->created_at && $a->created_at->gte($limite); })->count(),
        ];

        return view('gercont/associados', compact('associados', 'resumo'));
    }

    public function create()
    {
        Session::put('url', 'associados');

        return view('associado_admin/create', ['associado' => new Associado(['fl_ativo' => 1])]);
    }

    public function store(Request $request)
    {
        $this->validar($request);

        $associado = new Associado([
            'cpf' => $request->cpf,
            'nome' => $request->nome,
            'email' => $request->email,
            'fl_ativo' => $request->boolean('fl_ativo'),
            'origem' => Associado::ORIGEM_GERCONT,
        ]);

        if ($request->filled('password')) {
            $associado->password = Hash::make($request->password);
        }

        $associado->save();

        Flash::success('<i class="fa fa-check"></i> Associado <strong>' . e($associado->nome) . '</strong> cadastrado.');

        if ($request->boolean('enviar_acesso')) {
            $this->enviarLink($associado);
        }

        return redirect('gercont/associados');
    }

    public function edit($id)
    {
        Session::put('url', 'associados');
        $associado = Associado::findOrFail($id);

        return view('associado_admin/edit', compact('associado'));
    }

    public function update(Request $request, $id)
    {
        $associado = Associado::findOrFail($id);
        $this->validar($request, $associado);

        $associado->fill([
            'cpf' => $request->cpf,
            'nome' => $request->nome,
            'email' => $request->email,
            'fl_ativo' => $request->boolean('fl_ativo'),
        ]);

        if ($request->filled('password')) {
            $associado->password = Hash::make($request->password);
            $associado->remember_token = Str::random(60);
        }

        $associado->save();

        Flash::success('<i class="fa fa-check"></i> Dados de <strong>' . e($associado->nome) . '</strong> atualizados.');

        return redirect('associado-admin/' . $associado->id . '/edit');
    }

    public function toggleAtivo($id)
    {
        $associado = Associado::findOrFail($id);
        $associado->fl_ativo = !$associado->fl_ativo;
        if (!$associado->fl_ativo) {
            $associado->remember_token = Str::random(60);
        }
        $associado->save();

        Flash::success($associado->fl_ativo
            ? '<i class="fa fa-check"></i> Acesso de <strong>' . e($associado->nome) . '</strong> liberado.'
            : '<i class="fa fa-ban"></i> Acesso de <strong>' . e($associado->nome) . '</strong> bloqueado.');

        return redirect()->back();
    }

    public function enviarAcesso($id)
    {
        $associado = Associado::findOrFail($id);

        if (!$associado->fl_ativo) {
            Flash::warning('<i class="fa fa-warning"></i> Libere o acesso de <strong>' . e($associado->nome) . '</strong> antes de enviar o link.');
            return redirect()->back();
        }

        $this->enviarLink($associado);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $associado = Associado::findOrFail($id);
        $nome = $associado->nome;

        DB::table('associado_senha_reset')->where('email', $associado->email)->delete();
        $associado->delete();

        Flash::success('<i class="fa fa-trash"></i> Associado <strong>' . e($nome) . '</strong> excluído.');

        return redirect('gercont/associados');
    }

    private function enviarLink(Associado $associado): void
    {
        try {
            $status = Password::broker('associados')->sendResetLink(['cpf' => $associado->cpf]);
        } catch (\Throwable $e) {
            Log::error('Falha ao enviar link de acesso ao associado ' . $associado->id . ': ' . $e->getMessage());
            Flash::error('<i class="fa fa-warning"></i> Não foi possível enviar o e-mail para <strong>' . e($associado->email) . '</strong>. Verifique a configuração de e-mail do servidor.');
            return;
        }

        if ($status === Password::RESET_THROTTLED) {
            Flash::warning('<i class="fa fa-clock-o"></i> Um link acabou de ser enviado para <strong>' . e($associado->email) . '</strong>. Aguarde um minuto para reenviar.');
            return;
        }

        if ($status === Password::RESET_LINK_SENT) {
            Flash::info('<i class="fa fa-envelope"></i> Link de acesso enviado para <strong>' . e($associado->email) . '</strong> (válido por 24 horas).');
        }
    }

    private function validar(Request $request, Associado $associado = null): void
    {
        $request->merge(['cpf' => Cpf::limpar($request->input('cpf'))]);

        $unico = Rule::unique('associado', 'cpf');
        if ($associado) {
            $unico->ignore($associado->id);
        }

        $request->validate([
            'cpf' => ['required', 'digits:11', function ($atributo, $valor, $falha) {
                if (!Cpf::valido($valor)) {
                    $falha('O CPF informado não é válido.');
                }
            }, $unico],
            'nome' => 'required|string|min:5|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8|max:100',
        ], [
            'cpf.required' => 'Informe o CPF.',
            'cpf.digits' => 'O CPF deve ter 11 dígitos.',
            'cpf.unique' => 'Já existe um associado com este CPF.',
            'nome.required' => 'Informe o nome completo.',
            'nome.min' => 'Informe o nome completo.',
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
        ]);
    }
}
