<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;
use App\Models\User;

class ApiSecurity
{
    private $secretToken = 'sec!ReT423*&';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $result = false;

        $token = $request->bearerToken();

        $usuarios = User::selectRaw('users.id')
        ->where ( 'users.token', '=', $token)
        ->get();

        $status = '';

        foreach ($usuarios as $usuario) // Sempre vai retornar apenas 1 registro (cada pedido só tem 1 valor total), mas é preciso fazer um foreach para acessar o valor
        {
            $status = 'ok';
        }

        if ( $status == 'ok' )
        {
            $secret = $this->secretToken;

            $result = Token::validate($token, $secret);
        }

        if ( $result )
        {
            return $next($request);
        }
        else
        {
            return response()->json( [ 'success' => false, 'message' => 'Credenciais inválidas ou expiradas!'], 401);
        }
    }
}
