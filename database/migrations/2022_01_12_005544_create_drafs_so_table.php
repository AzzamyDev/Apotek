<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrafsSoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drafs_so', function (Blueprint $table) {
            $table->id();
            $table->integer('so_id');
            $table->integer('product_id');
            $table->string('name');
            $table->bigInteger('harga');
            $table->boolean('status')->default(false);
            $table->integer('stok_terakhir')->nullable();
            $table->integer('stok_akhir')->nullable();
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
        Schema::dropIfExists('drafs_so');
    }
}
