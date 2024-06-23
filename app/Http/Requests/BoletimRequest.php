<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoletimRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dt_publicacao' => 'required',
            'titulo' => 'required',
            'pdf' => 'required',
            'imagem' => 'required',
            'audio' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'dt_publicacao.required' => 'Campo <strong>Data de Publicação</strong> é obrigatório',
            'titulo.required' => 'Campo <strong>Título</strong> é obrigatório',
            'pdf.required' => 'Campo <strong>Arquivo PDF</strong> é obrigatório',
            'imagem.required' => 'Campo <strong>Arquivo Imagem</strong> é obrigatório',
            'audio.required' => 'Campo <strong>Arquivo Áudio</strong> é obrigatório'
        ];
    }
}
