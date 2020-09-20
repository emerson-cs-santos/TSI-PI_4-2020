<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if ( Auth::check() && Auth::user()->isAdmin() )
        {
            return $next($request);
        }

       Auth::logout();

       return redirect('home');

      // session()->flash('error', "Usuário não autorizado!");
    //    $msgLogin = 'Usuário não autorizado!';
       //return redirect('home', ['param'=>$teste]);

//       return Redirect::route('home')->with('msgLogin', $msgLogin);

      // return Redirect::route('home', array('msgLogin' => $msgLogin) );

//       return Redirect::route('home', [$msgLogin])->with('msgLogin', 'State saved correctly!!!');

 //      return Redirect::route('logout', $msgLogin)->with('msgLogin', 'State saved correctly!!!');


    }
}
