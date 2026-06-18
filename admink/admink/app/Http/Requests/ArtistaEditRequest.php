<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistaEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:60',
            'apelido' => 'max:60',
            'email' => 'required|email:rfc|max:60',
            'telefone' => 'required|string|min:14|max:15|regex:/^\(\d{2}\)\s\d{5}\-\d{4}$/',
            'data_nascimento' => 'nullable|date|before:-16 years|after:1920-01-01',
            'data_inicio' => 'required|date|before:tomorrow|after:2017-01-01',
            'data_fim' => 'nullable|date|before:tomorrow|after:data_inicio',
        ];
    }

    public function messages()
    {
        return [
            'data_nascimento.before'  => 'A idade do artista deve ser maior que 16 anos',
            'data_nascimento.after'  => 'A idade do artista deve ser menor que 100 anos',
            'data_inicio.before'  => 'A data de início não pode ser no futuro',
            'data_inicio.after'  => 'A data de início deve ser posterior ao ano de 2017',
            'data_fim.before'  => 'A data de fim não pode ser no futuro',
            'data_fim.after'  => 'A data de fim deve ser posterior à data de início',
        ];
    }
}
