<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class APIController extends Controller
{
    public function telaInicial()
    {
        $categorias     = Category::all()->sortByDesc('id')->take(3);
        $lancamentos    = Product::all()->sortByDesc('id')->take(4);
        $maisVendidos   = Product::all()->sortByDesc('sold')->take(4);

         // $categorias = Category::all()->where('home', '=' , 'S')->sortByDesc('id')->take(3);
        // $maisVendidos   = Product::all()->where('sold', '>' , 0)->sortByDesc('sold')->take(4);

      //  return response()->json( $categorias );

        return response()->json( array (
            'categorias'    => $categorias,
            'lancamentos'   => $lancamentos,
            'maisVendidos'  => $maisVendidos,
        ));

       // $carrossel      = Product::all()->where('home','S');
    }

    public function categorias()
    {
        $categorias = Category::all()->sortByDesc('id');

        return response()->json( $categorias );
    }

    public function categoriaProdutos( $id_categoria )
    {
        $produtos = Product::all()->where('category_id', '=' , $id_categoria)->sortByDesc('id');

        return response()->json( $produtos );
    }

    public function lancamentos()
    {
        $lancamentos    = Product::all()->sortByDesc('id');

        return response()->json( $lancamentos );
    }

    public function maisVendidos()
    {
        $maisVendidos   = Product::all()->sortByDesc('sold');

        return response()->json( $maisVendidos );
    }
}
