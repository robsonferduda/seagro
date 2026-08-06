<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicacaoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|min:3|max:255',
            'subtitulo' => 'nullable|max:500',
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'link_externo' => 'nullable|string|max:500',
            'nu_ordem' => 'nullable|integer|min:0',
            'fl_ativo' => 'nullable',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $temUpload = $this->hasFile('arquivo');
            $temLink = trim((string) $this->input('link_externo', '')) !== '';
            $mantemArquivo = $this->filled('arquivo_atual');

            if (!$temUpload && !$temLink && !$mantemArquivo) {
                $validator->errors()->add(
                    'arquivo',
                    'Informe um <strong>arquivo</strong> para upload ou um <strong>link externo</strong>.'
                );
            }
        });
    }

    public function messages()
    {
        return [
            'titulo.required' => 'Campo <strong>Título</strong> é obrigatório',
            'titulo.min' => 'Campo <strong>Título</strong> deve ter no mínimo 3 caracteres',
            'arquivo.mimes' => 'Campo <strong>Arquivo</strong> deve ser PDF, DOC ou DOCX',
            'arquivo.max' => 'Campo <strong>Arquivo</strong> não pode ser maior que 20MB',
        ];
    }
}
