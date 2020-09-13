<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagersRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'title' => 'required',
            'value' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Nome é informação obrigatória',
            'value.required' => 'Valor é informação obrigatória',
        ];
    }
}
