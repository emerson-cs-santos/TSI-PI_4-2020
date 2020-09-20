<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
      // $this->middleware('is_admin');
    }

    public function index()
    {
        return view('index');
    }

    public function index_home()
    {
        return redirect(route('admin'));
    }
}
