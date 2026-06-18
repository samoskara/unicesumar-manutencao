<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrcamentoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cliente'               => 'required',
            'artista'               => 'required',
            'tatuagem_nome'         => 'required|string|max:60',
            'tatuagem_local'        => 'required|string|max:60',
            'tatuagem_comprimento'  => 'required|numeric|min:0|max:200',
            'tatuagem_largura'      => 'required|numeric|min:0|max:200',
            'tatuagem_descricao'    => 'required|string|max:255',
            'tatuagem_referencias'  => 'max:65535',
            'canal_contato'         => 'max:20',
            'valor'                 => 'nullable|regex:/^(\d{1,2}\.)?\d{1,3},\d{2}$/',
            'tempo_estimado'        => [
                'nullable', 
                'regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',
            ],
            'observacao'            => 'max:255',
        ];
    }

    public function messages()
    {
        return [
            'tempo_estimado.regex' => 'O tempo estimado deve estar entre 00:00 e 23:59',
            'valor.regex' => 'O valor do orçamento deve estar entre R$ 0,00 e R$ 99.999,99',
        ];
    }
}