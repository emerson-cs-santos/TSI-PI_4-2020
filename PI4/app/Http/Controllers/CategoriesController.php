<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\EditCategoryRequest;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::selectRaw('categories.*')->orderByDesc('id')->paginate(5);

        return view('admin.categoria.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.categoria.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        Category::create([
            'name'  => $request->name
            ,'home' => $request->home
        ]);

       session()->flash('success', 'Categoria criada com sucesso!');

        return redirect(route('categories.index'));
    }

    public function show(Category $category)
    {
        return view('admin.categoria.show')->with('category', $category);
    }


    public function edit(Category $category)
    {
        return view('admin.categoria.edit')->with('category', $category);
    }


    public function update(EditCategoryRequest $request, Category $category)
    {
        $category->update([
            'name'  => $request->name
            ,'home' => $request->home
        ]);

        session()->flash('success', 'Categoria alterada com sucesso!');
        return redirect(route('categories.index'));
    }


    public function destroy($id)
    {
        $category = Category::withTrashed()->where('id', $id)->firstOrFail();

        $qtdProdutos = $category->products()->count();

        if( $qtdProdutos > 0 )
        {
            session()->flash('error', "Existem $qtdProdutos produtos com essa categoria!");
            return redirect()->back();
        }

        if($category->trashed())
        {
            $category->forceDelete();
            session()->flash('success', 'Categoria removida com sucesso!');
        }
        else
        {
            $category->delete();
            session()->flash('success', 'Categoria movida para lixeira com sucesso!');
        }
        return redirect()->back();
    }

    public function trashed()
    {
        $categories = Category::selectRaw('categories.*')->onlyTrashed()->orderByDesc('id')->paginate(5);
        return view('admin.categoria.index', ['categories' => $categories]);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->where('id', $id)->firstOrFail();
        $category->restore();
        session()->flash('success', 'Categoria ativada com sucesso!');
        return redirect()->back();
    }

    public function buscar(Request $request)
    {
        $buscar = $request->input('busca');

        if($buscar != "")
        {
            $categories = Category::selectRaw('categories.*')
            ->where ( 'categories.name', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'categories.id', 'LIKE', '%' . $buscar . '%' )
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            $pagination = $categories->appends ( array ('busca' => $request->input('busca')  ) );

            return view('admin.categoria.index')
            ->with('categories',$categories )->withQuery ( $buscar )
            ->with('busca',$buscar);
        }
        else
        {
            $categories = Category::selectRaw('categories.*')
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            return view('admin.categoria.index')
            ->with('categories', $categories )
            ->with('busca','');
        }
    }
}
