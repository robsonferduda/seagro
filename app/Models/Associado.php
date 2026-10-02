<?php

namespace App\Models;

use App\Support\Cpf;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

class Associado extends Authenticatable
{
    const ORIGEM_SITE = 'site';
    const ORIGEM_GERCONT = 'gercont';

    protected $table = 'associado';

    protected $fillable = [
        'cpf',
        'nome',
        'email',
        'password',
        'fl_ativo',
        'origem',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'fl_ativo' => 'boolean',
        'dt_ultimo_acesso' => 'datetime',
    ];

    public function setCpfAttribute($valor)
    {
        $this->attributes['cpf'] = Cpf::limpar($valor);
    }

    public function setEmailAttribute($valor)
    {
        $this->attributes['email'] = mb_strtolower(trim((string) $valor));
    }

    public function setNomeAttribute($valor)
    {
        $this->attributes['nome'] = preg_replace('/\s+/', ' ', trim((string) $valor));
    }

    public function scopeAtivos($query)
    {
        return $query->where('fl_ativo', 1);
    }

    public function cpfFormatado(): string
    {
        return Cpf::formatar($this->cpf);
    }

    public function cpfMascarado(): string
    {
        return Cpf::mascarar($this->cpf);
    }

    public function primeiroNome(): string
    {
        return explode(' ', (string) $this->nome)[0];
    }

    public function temSenha(): bool
    {
        return !empty($this->password);
    }

    public function registrarAcesso(): void
    {
        $this->timestamps = false;
        $this->forceFill(['dt_ultimo_acesso' => now()])->save();
        $this->timestamps = true;
    }

    public function sendPasswordResetNotification($token)
    {
        $associado = $this;
        $dados = [
            'nome' => $this->primeiroNome(),
            'link' => route('associado.senha.redefinir', $token),
            'primeiroAcesso' => !$this->temSenha(),
            'validadeHoras' => (int) ceil(config('auth.passwords.associados.expire', 1440) / 60),
        ];

        Mail::send('email/associado-acesso', $dados, function ($message) use ($associado, $dados) {
            $message->to($associado->email, $associado->nome)
                ->subject($dados['primeiroAcesso'] ? 'SEAGRO-SC - Crie sua senha da Área do Associado' : 'SEAGRO-SC - Redefinição de senha da Área do Associado');
            $message->from(config('mail.from.address', 'seagro@seagro-sc.org.br'), 'SEAGRO-SC');
        });
    }
}
