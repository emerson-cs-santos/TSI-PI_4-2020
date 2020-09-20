<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUsersRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                      => 'required|unique:users|min:3|alpha_num'
            ,'email'                    => 'required|unique:users|email:filter'
            ,'password'                 => 'required_with:password_confirmation|same:password_confirmation|min:8'
            ,'password_confirmation'    => 'min:8'
            ,'type'                     => 'required'
            ,'imagem'                   => 'max:2000'

            //,'imagem'                   => 'file|max:2000' , file obriga a ter um arquivo
        ];
    }
}
