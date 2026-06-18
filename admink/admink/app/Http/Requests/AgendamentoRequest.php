<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgendamentoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'orcamento' => 'required',
            'estacao' => 'required',
            'data_horario_inicio' => 'required|date|after:2017-01-01',
            'data_horario_fim' => 'required|date',
            'observacao' => 'nullable|max:255',
        ];
    }
}