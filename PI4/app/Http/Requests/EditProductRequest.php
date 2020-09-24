<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          => 'required'
            ,'imagem'       => 'max:2000'
            ,'descricao'    => 'required'
            ,'preco'        => 'required|max:10'
            ,'discount'     => 'max:5'
            ,'category_id'  => 'required'
            ,'stock'        => 'required'
        ];
    }
}
