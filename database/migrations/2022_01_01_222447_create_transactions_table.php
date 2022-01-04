<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi');
            $table->integer('petugas_id');
            $table->integer('shift_id');
            $table->timestamp('tanggal');
            $table->enum('jenis', ['Resep', 'Non Resep']);
            $table->enum('tipe_transaksi', ['Umum', 'Halodoc']);
            $table->enum('tipe_bayar', ['Tunai', 'Non Tunai']);
            $table->enum('bayar', ['Debit', 'Gopay', 'Ovo', 'Dana', 'LinkAja', ' Qris', 'Lainnya'])->nullable();
            $table->string('pasien')->nullable();
            $table->integer('dokter_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->bigInteger('total');
            $table->bigInteger('jumlah_bayar')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
