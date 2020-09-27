<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'fk_pedido'
        ,'product_id'
        ,'quantidade'
        ,'preco'
    ];

    public function pedido()
    {
     return $this->belongsTo(Pedido::class, 'fk_pedido');
    }

    public function produto()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
