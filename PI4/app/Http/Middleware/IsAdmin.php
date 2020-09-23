<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if ( Auth::check() && Auth::user()->isAdmin() )
        {
            return $next($request);
        }

        if ( Auth::check() )
        {
            return redirect('visitante');
        }

        return redirect('login');
        //return redirect('logout');


        // função logout não funciona mais no laravel 8:

        // Se não for admin, faz logout e volta para home
      // Auth::logout();

     //  return redirect('login');

    }
}
