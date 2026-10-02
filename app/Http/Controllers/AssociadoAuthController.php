<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Support\Cpf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AssociadoAuthController extends Controller
{
    const MAX_TENTATIVAS_LOGIN = 5;
    const BLOQUEIO_LOGIN_SEGUNDOS = 300;

    public function __construct()
    {
        $this->middleware('guest:associado')->except('logout');
        $this->middleware('auth:associado')->only('logout');
    }

    public function loginForm()
    {
        return view('associado/login');
    }

    public function login(Request $request)
    {
        $request->merge(['cpf' => Cpf::limpar($request->input('cpf'))]);
        $request->validate([
            'cpf' => 'required|digits:11',
            'password' => 'required|string',
        ], [
            'cpf.required' => 'Informe seu CPF.',
            'cpf.digits' => 'Informe um CPF com 11 dígitos.',
            'password.required' => 'Informe sua senha.',
        ]);

        $chave = 'associado-login|' . $request->cpf . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($chave, self::MAX_TENTATIVAS_LOGIN)) {
            $minutos = (int) ceil(RateLimiter::availableIn($chave) / 60);
            return $this->falhaLogin($request, "Muitas tentativas. Tente novamente em {$minutos} minuto(s).");
        }

        $associado = Associado::where('cpf', $request->cpf)->first();

        if (!$associado || !$associado->temSenha() || !Hash::check($request->password, $associado->password)) {
            RateLimiter::hit($chave, self::BLOQUEIO_LOGIN_SEGUNDOS);

            if ($associado && !$associado->temSenha()) {
                return $this->falhaLogin($request, 'Seu cadastro ainda não tem senha. Use "Primeiro acesso ou esqueci minha senha" para criá-la.');
            }

            return $this->falhaLogin($request, 'CPF ou senha incorretos.');
        }

        if (!$associado->fl_ativo) {
            return $this->falhaLogin($request, 'Seu acesso está bloqueado. Entre em contato com o SEAGRO-SC.');
        }

        RateLimiter::clear($chave);
        Auth::guard('associado')->login($associado, $request->boolean('lembrar'));
        $request->session()->regenerate();
        $associado->registrarAcesso();

        return redirect($this->destinoAposLogin($request));
    }

    public function cadastroForm()
    {
        return view('associado/cadastro');
    }

    public function cadastro(Request $request)
    {
        $request->merge(['cpf' => Cpf::limpar($request->input('cpf'))]);
        $request->validate([
            'cpf' => ['required', 'digits:11', $this->regraCpf(), Rule::unique('associado', 'cpf')],
            'nome' => 'required|string|min:5|max:255',
            'email' => 'required|email|max:255|confirmed',
            'password' => 'required|string|min:8|max:100|confirmed',
        ], $this->mensagens());

        $associado = Associado::create([
            'cpf' => $request->cpf,
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'fl_ativo' => 1,
            'origem' => Associado::ORIGEM_SITE,
        ]);

        Auth::guard('associado')->login($associado);
        $request->session()->regenerate();
        $associado->registrarAcesso();

        return redirect()->route('associado.area')
            ->with('sucesso', 'Cadastro realizado! Bem-vindo(a) à Área do Associado.');
    }

    public function recuperarForm()
    {
        return view('associado/recuperar');
    }

    public function recuperar(Request $request)
    {
        $request->merge(['cpf' => Cpf::limpar($request->input('cpf'))]);
        $request->validate(['cpf' => 'required|digits:11'], [
            'cpf.required' => 'Informe seu CPF.',
            'cpf.digits' => 'Informe um CPF com 11 dígitos.',
        ]);

        $associado = Associado::where('cpf', $request->cpf)->first();

        if ($associado && $associado->fl_ativo) {
            try {
                Password::broker('associados')->sendResetLink(['cpf' => $request->cpf]);
            } catch (\Throwable $e) {
                Log::error('Falha ao enviar link de acesso ao associado ' . $associado->id . ': ' . $e->getMessage());
                return back()->withInput()->withErrors(['cpf' => 'Não foi possível enviar o e-mail agora. Tente novamente mais tarde ou entre em contato com o SEAGRO-SC.']);
            }
        }

        return back()->with('sucesso', 'Se o CPF estiver cadastrado, enviamos um link para o e-mail informado no cadastro. O link vale por 24 horas; verifique também a caixa de spam.');
    }

    public function redefinirForm($token)
    {
        return view('associado/redefinir', compact('token'));
    }

    public function redefinir(Request $request)
    {
        $request->merge(['cpf' => Cpf::limpar($request->input('cpf'))]);
        $request->validate([
            'token' => 'required',
            'cpf' => 'required|digits:11',
            'password' => 'required|string|min:8|max:100|confirmed',
        ], $this->mensagens());

        $associadoRedefinido = null;
        $status = Password::broker('associados')->reset(
            $request->only('cpf', 'password', 'token'),
            function (Associado $associado, $senha) use (&$associadoRedefinido) {
                $associado->forceFill([
                    'password' => Hash::make($senha),
                    'remember_token' => Str::random(60),
                ])->save();
                $associadoRedefinido = $associado;
            }
        );

        if ($status !== Password::PASSWORD_RESET || !$associadoRedefinido) {
            return back()->withInput($request->only('cpf'))
                ->withErrors(['cpf' => 'Link inválido ou expirado, ou o CPF não corresponde a este link. Solicite um novo link.']);
        }

        if (!$associadoRedefinido->fl_ativo) {
            return redirect()->route('associado.login')
                ->with('sucesso', 'Senha definida, mas seu acesso está bloqueado. Entre em contato com o SEAGRO-SC.');
        }

        Auth::guard('associado')->login($associadoRedefinido);
        $request->session()->regenerate();
        $associadoRedefinido->registrarAcesso();

        return redirect()->route('associado.area')->with('sucesso', 'Senha definida com sucesso!');
    }

    public function logout(Request $request)
    {
        Auth::guard('associado')->logout();
        $request->session()->regenerateToken();

        return redirect()->route('associado.login')->with('sucesso', 'Você saiu da Área do Associado.');
    }

    private function destinoAposLogin(Request $request): string
    {
        $area = route('associado.area');
        $destino = (string) $request->session()->pull('url.intended');

        if ($destino === $area || Str::startsWith($destino, $area . '/')) {
            return $destino;
        }

        return $area;
    }

    private function falhaLogin(Request $request, string $mensagem)
    {
        return back()->withInput($request->only('cpf', 'lembrar'))->withErrors(['cpf' => $mensagem]);
    }

    private function regraCpf()
    {
        return function ($atributo, $valor, $falha) {
            if (!Cpf::valido($valor)) {
                $falha('O CPF informado não é válido.');
            }
        };
    }

    private function mensagens(): array
    {
        return [
            'cpf.required' => 'Informe seu CPF.',
            'cpf.digits' => 'Informe um CPF com 11 dígitos.',
            'cpf.unique' => 'Este CPF já possui cadastro. Entre com sua senha ou use "Primeiro acesso ou esqueci minha senha".',
            'nome.required' => 'Informe seu nome completo.',
            'nome.min' => 'Informe seu nome completo.',
            'email.required' => 'Informe seu e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'email.confirmed' => 'A confirmação do e-mail não confere.',
            'password.required' => 'Informe uma senha.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ];
    }
}
