<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoletimUpdateRequest extends FormRequest
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
            'dt_publicacao' => 'required|date_format:d/m/Y',
            'titulo' => 'required|min:3|max:255',
            'subtitulo' => 'nullable|max:255',
            'texto' => 'nullable',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
            'imagem' => 'nullable|file|mimes:jpeg,jpg,png|max:5120',
            'audio' => 'nullable|file|mimes:mp3,wav,mpeg,mpga|max:20480'
        ];
    }

    public function messages()
    {
        return [
            'dt_publicacao.required' => 'Campo <strong>Data de Publicação</strong> é obrigatório',
            'dt_publicacao.date_format' => 'Campo <strong>Data de Publicação</strong> deve estar no formato dd/mm/aaaa',
            'titulo.required' => 'Campo <strong>Título</strong> é obrigatório',
            'titulo.min' => 'Campo <strong>Título</strong> deve ter no mínimo 3 caracteres',
            'titulo.max' => 'Campo <strong>Título</strong> deve ter no máximo 255 caracteres',
            'subtitulo.max' => 'Campo <strong>Subtítulo</strong> deve ter no máximo 255 caracteres',
            'pdf.mimes' => 'Campo <strong>Arquivo PDF</strong> deve ser um arquivo PDF',
            'pdf.max' => 'Campo <strong>Arquivo PDF</strong> não pode ser maior que 10MB',
            'imagem.mimes' => 'Campo <strong>Arquivo Imagem</strong> deve ser JPG, JPEG ou PNG',
            'imagem.max' => 'Campo <strong>Arquivo Imagem</strong> não pode ser maior que 5MB',
            'audio.mimes' => 'Campo <strong>Arquivo Áudio</strong> deve ser MP3 ou WAV',
            'audio.max' => 'Campo <strong>Arquivo Áudio</strong> não pode ser maior que 20MB'
        ];
    }
}
