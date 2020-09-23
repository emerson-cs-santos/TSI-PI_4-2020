<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Category;

class VerifyCategoriesCount
{
    public function handle(Request $request, Closure $next)
    {
        if( Category::all()->count() == 0 )
        {
            session()->flash('error', 'Você precisa criar uma categoria antes de criar um produto!');
            return redirect(route('categories.create'));
        }

        return $next($request);
    }
}
