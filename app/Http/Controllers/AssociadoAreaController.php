<?php

namespace App\Http\Controllers;

use App\Models\Pagina;
use App\Support\DadosPessoais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AssociadoAreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:associado');
        $this->middleware(function ($request, $next) {
            if (!Auth::guard('associado')->user()->fl_ativo) {
                Auth::guard('associado')->logout();
                $request->session()->regenerateToken();

                return redirect()->route('associado.login')
                    ->withErrors(['cpf' => 'Seu acesso está bloqueado. Entre em contato com o SEAGRO-SC.']);
            }

            return $next($request);
        });
    }

    public function index()
    {
        $associado = Auth::guard('associado')->user();
        $paginaFiqueSocio = Pagina::where('apelido', 'fique-socio')->where('fl_publicacao', 1)->first();
        $documentos = $paginaFiqueSocio
            ? $paginaFiqueSocio->documentos()->ativos()->ordenados()->get()
            : collect();

        return view('associado/area', compact('associado', 'documentos'));
    }

    public function meusDados()
    {
        $associado = Auth::guard('associado')->user()->load(['cidade.uf', 'naturalidade.uf']);

        return view('associado/meus-dados', array_merge(compact('associado'), DadosPessoais::dadosFormulario($associado)));
    }

    public function atualizarDados(Request $request)
    {
        $associado = Auth::guard('associado')->user();

        DadosPessoais::normalizar($request);

        $request->validate(array_merge([
            'nome' => 'required|string|min:5|max:255',
            'email' => 'required|email|max:255',
        ], DadosPessoais::regras()), array_merge([
            'nome.required' => 'Informe seu nome completo.',
            'nome.min' => 'Informe seu nome completo.',
            'email.required' => 'Informe seu e-mail particular.',
            'email.email' => 'Informe um e-mail particular válido.',
        ], DadosPessoais::mensagens()));

        $associado->update(array_merge($request->only('nome', 'email'), DadosPessoais::dados($request)));
        DadosPessoais::aplicarFoto($request, $associado);

        return redirect()->route('associado.dados')->with('sucesso', 'Dados atualizados.');
    }

    public function foto()
    {
        $associado = Auth::guard('associado')->user();
        abort_unless($associado->temFoto(), 404);

        return response()->file($associado->caminhoFoto(), ['Cache-Control' => 'private, max-age=604800']);
    }

    public function alterarSenha(Request $request)
    {
        $associado = Auth::guard('associado')->user();

        $request->validateWithBag('senha', [
            'senha_atual' => 'required|string',
            'password' => 'required|string|min:8|max:100|confirmed|different:senha_atual',
        ], [
            'senha_atual.required' => 'Informe sua senha atual.',
            'password.required' => 'Informe a nova senha.',
            'password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da nova senha não confere.',
            'password.different' => 'A nova senha deve ser diferente da atual.',
        ]);

        if (!Hash::check($request->senha_atual, $associado->password)) {
            return back()->withErrors(['senha_atual' => 'A senha atual está incorreta.'], 'senha');
        }

        $associado->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        return redirect()->route('associado.dados')->with('sucesso', 'Senha alterada com sucesso.');
    }
}
