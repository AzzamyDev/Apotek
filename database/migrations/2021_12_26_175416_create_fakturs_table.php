<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaktursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fakturs', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->integer('petugas_id');
            $table->string('no_faktur')->unique();
            $table->string('no_sp')->unique();
            $table->timestamp('tanggal');
            $table->bigInteger('total');
            $table->bigInteger('total_real');
            $table->bigInteger('grand_total');
            $table->bigInteger('biaya_lain')->nullable();
            $table->integer('items');
            $table->text('keterangan')->nullable();
            $table->dateTime('tempo')->nullable();
            $table->enum('bayar', ['Tunai', 'Kredit']);
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
        Schema::dropIfExists('fakturs');
    }
}
