<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OportunidadeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|min:3|max:255',
            'descricao' => 'required',
            'empresa' => 'nullable|max:255',
            'tipo' => 'required|max:50',
            'localizacao' => 'nullable|max:255',
            'salario' => 'nullable|max:100',
            'dt_publicacao' => 'required|date_format:d/m/Y',
            'dt_validade' => 'nullable|date_format:d/m/Y|after:dt_publicacao',
            'link_externo' => 'nullable|url|max:500',
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'Campo <strong>Título</strong> é obrigatório',
            'titulo.min' => 'Campo <strong>Título</strong> deve ter no mínimo 3 caracteres',
            'titulo.max' => 'Campo <strong>Título</strong> deve ter no máximo 255 caracteres',
            'descricao.required' => 'Campo <strong>Descrição</strong> é obrigatório',
            'tipo.required' => 'Campo <strong>Tipo</strong> é obrigatório',
            'empresa.max' => 'Campo <strong>Empresa</strong> deve ter no máximo 255 caracteres',
            'localizacao.max' => 'Campo <strong>Localização</strong> deve ter no máximo 255 caracteres',
            'salario.max' => 'Campo <strong>Salário</strong> deve ter no máximo 100 caracteres',
            'dt_publicacao.required' => 'Campo <strong>Data de Publicação</strong> é obrigatório',
            'dt_publicacao.date_format' => 'Campo <strong>Data de Publicação</strong> deve estar no formato dd/mm/aaaa',
            'dt_validade.date_format' => 'Campo <strong>Data de Validade</strong> deve estar no formato dd/mm/aaaa',
            'dt_validade.after' => 'Campo <strong>Data de Validade</strong> deve ser posterior à data de publicação',
            'link_externo.url' => 'Campo <strong>Link Externo</strong> deve ser uma URL válida',
            'link_externo.max' => 'Campo <strong>Link Externo</strong> deve ter no máximo 500 caracteres',
            'arquivo.mimes' => 'Campo <strong>Arquivo</strong> deve ser PDF, DOC ou DOCX',
            'arquivo.max' => 'Campo <strong>Arquivo</strong> não pode ser maior que 5MB'
        ];
    }
}
