<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPedidosTable extends Migration
{
    public function up()
    {
        Schema::create('item_pedidos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_pedido')->references('id')->on('pedidos')->default(0);
            $table->integer('product_id')->references('id')->on('products')->default(0);
            $table->integer('quantidade');
            $table->decimal('preco',8,2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_pedidos');
    }
}
