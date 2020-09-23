<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->mediumText('image')->default('');
            $table->text('desc');
            $table->decimal('price',8,2);
            $table->decimal('discount',5,2);
            $table->integer('stock')->default(0);
            $table->integer('sold')->default(0);
            $table->string('home')->default('N');            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
