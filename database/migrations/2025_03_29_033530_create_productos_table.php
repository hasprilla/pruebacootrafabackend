<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('inventory_id');
            $table->string('name');
            $table->string('barcode')->unique();
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('inventory_id')->references('id')->on('inventarios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
