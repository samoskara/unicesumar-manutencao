<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrcamentoEditRequest extends FormRequest
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
}