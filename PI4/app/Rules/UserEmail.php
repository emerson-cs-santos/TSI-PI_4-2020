<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\User;

class UserEmail implements Rule
{
    private $mensagemErro = '';
    public function __construct( array $data )
    {
        $this->data = $data;
    }

    public function passes($attribute, $value)
    {
        $id      = $this->data['id'];
        $email   = $this->data['email'];
        $usuario = User::find($id);

        $validarEmail = User::withTrashed()
        ->where('email','!=',$usuario->email)
        ->where('email','=',$email)
        ->count();

        if ( $validarEmail > 0 )
        {
            $this->mensagemErro = "Email $email está sendo utilizado em outro cadastro!";
            return false;
        }
        else
        {
            return true;
        }
    }

    public function message()
    {
        return $this->mensagemErro;
    }
}
