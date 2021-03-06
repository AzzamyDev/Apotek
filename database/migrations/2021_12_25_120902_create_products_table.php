<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('golongan');
            $table->integer('tipe_barang_id');
            $table->integer('tipe_harga_id');
            $table->string('lokasi')->nullable();
            $table->string('satuan');
            $table->bigInteger('harga');
            $table->boolean('status')->default(true);
            $table->bigInteger('stok')->default(0);
            $table->bigInteger('min_stok')->nullable();
            $table->bigInteger('max_stok')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
