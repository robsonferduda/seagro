<?php

namespace App\Support;

use App\Models\Associado;
use App\Models\Cidade;
use App\Models\Sexo;
use App\Models\Uf;
use Illuminate\Http\Request;

/**
 * Bloco "Dados pessoais" do associado, compartilhado entre o painel (gercont) e a Área do Associado.
 */
class DadosPessoais
{
    const CAMPOS = [
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

    const CAMPOS_NUMERICOS = ['cep', 'telefone_residencial', 'telefone_celular', 'telefone_comercial'];

    public static function normalizar(Request $request): void
    {
        $limpos = [];
        foreach (self::CAMPOS_NUMERICOS as $campo) {
            $digitos = preg_replace('/\D/', '', (string) $request->input($campo));
            $limpos[$campo] = $digitos === '' ? null : $digitos;
        }

        $request->merge($limpos);
    }

    public static function regras(): array
    {
        return [
            'dt_nascimento' => 'nullable|date|before:today|after:1900-01-01',
            'id_sexo' => 'nullable|integer|exists:sexo,id',
            'id_cidade_naturalidade' => 'nullable|integer|exists:cidade,id',
            'cep' => 'nullable|digits:8',
            'logradouro' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'id_cidade' => 'nullable|integer|exists:cidade,id',
            'email_trabalho' => 'nullable|email|max:255',
            'telefone_residencial' => 'nullable|digits_between:10,11',
            'telefone_celular' => 'nullable|digits:11',
            'telefone_comercial' => 'nullable|digits_between:10,11',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }

    public static function mensagens(): array
    {
        return [
            'dt_nascimento.date' => 'Informe uma data de nascimento válida.',
            'dt_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            'dt_nascimento.after' => 'Informe uma data de nascimento válida.',
            'id_sexo.exists' => 'Selecione um sexo válido.',
            'id_cidade_naturalidade.exists' => 'Selecione uma cidade de naturalidade válida.',
            'cep.digits' => 'O CEP deve ter 8 dígitos.',
            'logradouro.max' => 'O endereço pode ter no máximo 255 caracteres.',
            'numero.max' => 'O número pode ter no máximo 20 caracteres.',
            'complemento.max' => 'O complemento pode ter no máximo 100 caracteres.',
            'bairro.max' => 'O bairro pode ter no máximo 100 caracteres.',
            'id_cidade.exists' => 'Selecione uma cidade válida para o endereço.',
            'email_trabalho.email' => 'Informe um e-mail de trabalho válido.',
            'telefone_residencial.digits_between' => 'Informe o telefone residencial com DDD.',
            'telefone_celular.digits' => 'Informe o celular com DDD e 9 dígitos.',
            'telefone_comercial.digits_between' => 'Informe o telefone comercial com DDD.',
            'foto.uploaded' => 'Não foi possível enviar a foto. Tente uma imagem menor.',
            'foto.image' => 'A foto deve ser uma imagem.',
            'foto.mimes' => 'A foto deve estar em JPG, PNG ou WEBP.',
            'foto.max' => 'A foto pode ter no máximo 5MB.',
        ];
    }

    public static function aplicarFoto(Request $request, Associado $associado): void
    {
        if ($request->hasFile('foto')) {
            $associado->salvarFoto($request->file('foto'));
        } elseif ($request->boolean('remover_foto')) {
            $associado->removerFoto();
        }
    }

    /**
     * Campos ausentes no request (ex.: select de cidade desabilitado sem UF) viram null,
     * para que limpar a UF também limpe a cidade gravada.
     */
    public static function dados(Request $request): array
    {
        $dados = [];
        foreach (self::CAMPOS as $campo) {
            $dados[$campo] = $request->input($campo);
        }

        return $dados;
    }

    public static function dadosFormulario(Associado $associado): array
    {
        $ufResidencia = old('uf_residencia', optional(optional($associado->cidade)->uf)->sigla);
        $ufNaturalidade = old('uf_naturalidade', optional(optional($associado->naturalidade)->uf)->sigla);

        return [
            'ufs' => Uf::orderBy('sigla')->get(),
            'sexos' => Sexo::orderBy('id')->get(),
            'ufResidencia' => $ufResidencia,
            'ufNaturalidade' => $ufNaturalidade,
            'cidadesResidencia' => Cidade::listaDaUf($ufResidencia),
            'cidadesNaturalidade' => Cidade::listaDaUf($ufNaturalidade),
        ];
    }
}
