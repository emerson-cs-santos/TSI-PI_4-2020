<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =
    [
        'user_id'
        ,'cliente_id'
    ];

    public function usuario()
    {
     return $this->belongsTo(User::class, 'user_id');
    }

    public function pedidoTemItens()
    {
        return $this->hasMany(ItemPedido::class, 'fk_pedido', 'id');
    }

    public function valorTotal()
    {
      // $itens = $this->pedidoTemItens();

       $valores = ItemPedido::selectRaw('sum(item_pedidos.quantidade * item_pedidos.preco) as total')->where('fk_pedido', '=', $this->id)->groupBy('fk_pedido')->get();
       $valorTotal = '0';
       foreach ($valores as $valor) // Sempre vai retornar apenas 1 registro (cada pedido só tem 1 valor total), mas é preciso fazer um foreach para acessar o valor
       {
            $valorTotal = floatval($valor->total);
       }
        return 'R$'.number_format($valorTotal, 2,',','.');
    }
}
