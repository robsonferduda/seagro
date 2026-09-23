<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GaleriaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'nullable|max:255',
            'imagens' => 'required|array|min:1',
            'imagens.*' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'imagens.required' => 'Selecione ao menos uma imagem',
            'imagens.*.image' => 'Cada arquivo deve ser uma imagem válida',
            'imagens.*.mimes' => 'Formatos aceitos: JPG, JPEG, PNG, GIF ou WEBP',
            'imagens.*.max' => 'Cada imagem não pode ser maior que 5MB',
        ];
    }
}
