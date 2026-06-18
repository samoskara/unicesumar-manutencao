<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:60',
            'apelido' => 'required|string|max:60',
            'email' => 'required|email:rfc|unique:App\Artista,email|max:60',
            'telefone' => 'required|string|min:14|max:15|regex:/^\(\d{2}\)\s\d{5}\-\d{4}$/',
            'data_nascimento' => 'nullable|date|before:-16 years|after:1920-01-01'
        ];
    }

    public function messages()
    {
        return [
            'data_nascimento.before'  => 'A idade do artista deve ser maior que 16 anos',
            'data_nascimento.after'  => 'A idade do artista deve ser menor que 100 anos',
        ];
    }
}
