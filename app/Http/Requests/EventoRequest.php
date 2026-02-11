<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventoRequest extends FormRequest
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
            'id_tipo' => 'required|exists:tipo_evento,id',
            'data' => 'required|date_format:d/m/Y',
            'titulo' => 'required|min:3|max:255',
            'descricao' => 'nullable',
            'imagem' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120'
        ];
    }

    public function messages()
    {
        return [
            'id_tipo.required' => 'Campo <strong>Tipo de Evento</strong> é obrigatório',
            'id_tipo.exists' => 'Tipo de evento inválido',
            'data.required' => 'Campo <strong>Data do Evento</strong> é obrigatório',
            'data.date_format' => 'Campo <strong>Data do Evento</strong> deve estar no formato dd/mm/aaaa',
            'titulo.required' => 'Campo <strong>Título</strong> é obrigatório',
            'titulo.min' => 'Campo <strong>Título</strong> deve ter no mínimo 3 caracteres',
            'titulo.max' => 'Campo <strong>Título</strong> deve ter no máximo 255 caracteres',
            'imagem.mimes' => 'Campo <strong>Imagem</strong> deve ser JPG, JPEG, PNG ou PDF',
            'imagem.max' => 'Campo <strong>Imagem</strong> não pode ser maior que 5MB'
        ];
    }
}
