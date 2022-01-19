<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemRacikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_racikans', function (Blueprint $table) {
            $table->id();
            $table->integer('racikan_id');
            $table->integer('product_id');
            $table->string('nama_barang');
            $table->integer('qty');
            $table->integer('jenis_harga_id');
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual'); //+ppn
            $table->bigInteger('sub_total');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('item_racikans');
    }
}
