<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_ins', function (Blueprint $table) {
            $table->id();
            $table->integer('faktur_id');
            $table->integer('product_id');
            $table->string('nama_barang');
            $table->string('batch');
            $table->date('expired');
            $table->bigInteger('harga_beli');
            $table->decimal('diskon');
            $table->decimal('diskon_real');
            $table->integer('qty');
            $table->bigInteger('sub_total');
            $table->bigInteger('sub_total_real');
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
        Schema::dropIfExists('order_ins');
    }
}
