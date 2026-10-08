<?php

namespace App\Models;

use App\Support\Cpf;
use App\Support\ImagemCapa;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;

class Associado extends Authenticatable
{
    const ORIGEM_SITE = 'site';
    const ORIGEM_GERCONT = 'gercont';

    const PASTA_FOTOS = 'app/associados/fotos';
    const FOTO_LADO_MAX = 800;

    protected $table = 'associado';

    protected $fillable = [
        'cpf',
        'nome',
        'email',
        'password',
        'fl_ativo',
        'origem',
        'dt_nascimento',
        'id_sexo',
        'id_cidade_naturalidade',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'id_cidade',
        'email_trabalho',
        'telefone_residencial',
        'telefone_celular',
        'telefone_comercial',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'fl_ativo' => 'boolean',
        'dt_ultimo_acesso' => 'datetime',
        'dt_nascimento' => 'date',
    ];

    public function sexo()
    {
        return $this->belongsTo(Sexo::class, 'id_sexo');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'id_cidade');
    }

    public function naturalidade()
    {
        return $this->belongsTo(Cidade::class, 'id_cidade_naturalidade');
    }

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

    public function setEmailTrabalhoAttribute($valor)
    {
        $valor = mb_strtolower(trim((string) $valor));
        $this->attributes['email_trabalho'] = $valor === '' ? null : $valor;
    }

    public function setCepAttribute($valor)
    {
        $this->attributes['cep'] = self::somenteDigitos($valor);
    }

    public function setTelefoneResidencialAttribute($valor)
    {
        $this->attributes['telefone_residencial'] = self::somenteDigitos($valor);
    }

    public function setTelefoneCelularAttribute($valor)
    {
        $this->attributes['telefone_celular'] = self::somenteDigitos($valor);
    }

    public function setTelefoneComercialAttribute($valor)
    {
        $this->attributes['telefone_comercial'] = self::somenteDigitos($valor);
    }

    private static function somenteDigitos($valor): ?string
    {
        $digitos = preg_replace('/\D/', '', (string) $valor);

        return $digitos === '' ? null : $digitos;
    }

    public static function pastaFotos(): string
    {
        return storage_path(self::PASTA_FOTOS);
    }

    public function caminhoFoto(): ?string
    {
        return $this->foto ? self::pastaFotos() . '/' . $this->foto : null;
    }

    public function temFoto(): bool
    {
        $caminho = $this->caminhoFoto();

        return $caminho !== null && is_file($caminho);
    }

    public function salvarFoto(UploadedFile $arquivo): void
    {
        $anterior = $this->caminhoFoto();

        $this->foto = ImagemCapa::salvar($arquivo, self::pastaFotos(), $this->id . '-' . time(), self::FOTO_LADO_MAX, self::FOTO_LADO_MAX);
        $this->save();

        if ($anterior && $anterior !== $this->caminhoFoto() && is_file($anterior)) {
            @unlink($anterior);
        }
    }

    public function removerFoto(): void
    {
        if ($this->temFoto()) {
            @unlink($this->caminhoFoto());
        }

        if ($this->foto !== null) {
            $this->foto = null;
            $this->save();
        }
    }

    public function cepFormatado(): string
    {
        $cep = (string) $this->cep;

        return strlen($cep) === 8 ? substr($cep, 0, 5) . '-' . substr($cep, 5) : $cep;
    }

    public static function formatarTelefone($numero): string
    {
        $numero = (string) $numero;

        if (strlen($numero) === 11) {
            return '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 5) . '-' . substr($numero, 7);
        }

        if (strlen($numero) === 10) {
            return '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 4) . '-' . substr($numero, 6);
        }

        return $numero;
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
