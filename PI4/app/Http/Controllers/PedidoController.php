<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Product;
use App\Models\ItemPedido;

class PedidoController extends Controller
{
    public function index_pedido()
    {
        $pedido = Pedido::selectRaw('pedidos.*')->orderByDesc('id')->paginate(5);
        return view('admin.pedido.index', ['pedidos' => $pedido]);
    }

    public function index_itensPedido($idPedido)
    {
        $itemPedido = ItemPedido::selectRaw('item_pedidos.*')->where('fk_pedido', '=', $idPedido)->orderBy('id')->paginate(8);
        $pedido     = Pedido::withTrashed()->find($idPedido);
        return view('admin.pedido.pedido', ['itensPedido' => $itemPedido] )->with( ['pedido' => $pedido] );
    }

    public function destroy($id)
    {
        $pedido = Pedido::withTrashed()->where('id', $id)->firstOrFail();

        if($pedido->trashed())
        {
            $pedido->forceDelete();
            session()->flash('success', 'Pedido removido do sistema com sucesso!');
        }
        else
        {
            $Itens = ItemPedido::all()->where('fk_pedido',$id);

            foreach ($Itens as $item)
            {
                $produto = Product::find( $item->product_id );
                $produto->stock = $produto->stock + $item->quantidade;
                $produto->sold  = $produto->sold - $item->quantidade;

                $produto->save();
            }

            $pedido->delete();
            session()->flash('success', "Pedido Nro $id cancelado com sucesso!");
        }
        return redirect()->back();
    }

    public function trashed()
    {
        $pedido = Pedido::selectRaw('pedidos.*')->onlyTrashed()->orderByDesc('id')->paginate(5);
        return view('admin.pedido.index', ['pedidos' => $pedido]);
    }

    public function restore($id)
    {
        $pedido = Pedido::withTrashed()->where('id', $id)->firstOrFail();
        $pedido->restore();
        session()->flash('success', 'Pedido ativado com sucesso!');
        return redirect()->back();
    }

    public function buscar(Request $request)
    {
        $buscar = $request->input('busca');

        if($buscar != "")
        {
            $pedidos = Pedido::selectRaw('pedidos.*')
            ->join('users', 'users.id', 'pedidos.user_id')
            ->where ( 'pedidos.id', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'pedidos.updated_at', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'users.id', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'users.name', 'LIKE', '%' . $buscar . '%' )
            ->orderByDesc('id')
            ->paginate(5)
            ->setPath ( '' );

            $pagination = $pedidos->appends ( array ('busca' => $request->input('busca')  ) );

            return view('admin.pedido.index')
            ->with('pedidos',$pedidos )->withQuery ( $buscar )
            ->with('busca',$buscar);
        }
        else
        {
            $pedidos = Pedido::selectRaw('pedidos.*')
            ->orderByDesc('id')
            ->paginate(5)
            ->setPath ( '' );

            return view('admin.pedido.index')
            ->with('pedidos', $pedidos )
            ->with('busca','');
        }
    }

}
