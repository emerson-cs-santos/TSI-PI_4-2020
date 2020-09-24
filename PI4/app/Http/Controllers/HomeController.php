<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function index_home()
    {
        return redirect(route('admin'));
    }

    public function visitante()
    {
        return view('semAcesso');
    }

    public function sobre()
    {
        return view('sobre');
    }
}
