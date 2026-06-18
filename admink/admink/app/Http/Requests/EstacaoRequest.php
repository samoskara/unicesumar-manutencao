<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstacaoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'identificacao' => 'required|string|max:20',
        ];
    }
}
