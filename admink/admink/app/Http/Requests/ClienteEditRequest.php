<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteEditRequest extends FormRequest
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
            'observacao' => 'max:255',
        ];
    }

    public function messages()
    {
        return [
            'data_nascimento.before'  => 'A idade do cliente deve ser maior que 16 anos',
            'data_nascimento.after'  => 'A idade do cliente deve ser menor que 100 anos',
        ];
    }
}
