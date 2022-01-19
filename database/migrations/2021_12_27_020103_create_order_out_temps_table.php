<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderOutTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_out_temps', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_order', ['product', 'racikan', 'pelayanan']);
            $table->integer('product_id')->nullable();
            $table->integer('racikan_id')->nullable();
            $table->string('nama_barang');
            $table->integer('qty');
            $table->integer('jenis_harga_id')->nullable();
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual'); //+ppn
            $table->bigInteger('sub_total');
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
        Schema::dropIfExists('order_out_temps');
    }
}
