<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'tp_destino' => $this->input('tp_destino', 'conteudo'),
            'fl_nova_aba' => $this->boolean('fl_nova_aba') ? 1 : 0,
        ]);
    }

    public function rules()
    {
        $tpDestino = $this->input('tp_destino', 'conteudo');

        return [
            'id_tipo' => 'required|exists:tipo_evento,id',
            'data' => 'required|date_format:d/m/Y',
            'titulo' => 'required|min:3|max:255',
            'tp_destino' => ['required', Rule::in(['conteudo', 'redirect'])],
            'descricao' => 'nullable',
            'url_destino' => [
                Rule::requiredIf($tpDestino === 'redirect'),
                'nullable',
                'string',
                'max:500',
                function ($attribute, $value, $fail) use ($tpDestino) {
                    if ($tpDestino !== 'redirect' || empty($value)) {
                        return;
                    }

                    $okAbsolute = filter_var($value, FILTER_VALIDATE_URL);
                    $okRelative = strpos($value, '/') === 0;

                    if (!$okAbsolute && !$okRelative) {
                        $fail('Campo <strong>URL de destino</strong> deve ser uma URL válida ou um caminho interno iniciando com /');
                    }
                },
            ],
            'fl_nova_aba' => 'nullable|boolean',
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
            'tp_destino.required' => 'Campo <strong>Como o evento deve abrir</strong> é obrigatório',
            'tp_destino.in' => 'Opção de destino inválida',
            'url_destino.required' => 'Campo <strong>URL de destino</strong> é obrigatório quando o evento redireciona',
            'url_destino.max' => 'Campo <strong>URL de destino</strong> deve ter no máximo 500 caracteres',
            'imagem.mimes' => 'Campo <strong>Imagem</strong> deve ser JPG, JPEG, PNG ou PDF',
            'imagem.max' => 'Campo <strong>Imagem</strong> não pode ser maior que 5MB'
        ];
    }
}
