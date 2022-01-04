<?php

use App\Http\Livewire\admin\Dokter;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\admin\Karyawan;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\AturanPakai;
use App\Http\Livewire\admin\JenisHarga;
use App\Http\Livewire\Admin\TipeBarang;
use App\Http\Livewire\App\Home;
use App\Http\Livewire\Gudang\Product;
use App\Http\Livewire\Gudang\Supplier;
use App\Http\Livewire\Gudang\Faktur;
use App\Http\Livewire\Transaksi\NonResep\Form as NonResepForm;
use App\Http\Livewire\Transaksi\NonResep\Laporan as LaporanNonResep;
use App\Http\Livewire\Transaksi\NonResep\Detail as DetailNonResep;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/home', Home::class)->name('home');
    //admin
    Route::get('karyawan', Karyawan\Index::class)->name('karyawan');
    Route::get('dokter', Dokter\Index::class)->name('dokter');
    Route::get('harga', JenisHarga\Index::class)->name('harga');
    Route::get('aturan-pakai', AturanPakai\Index::class)->name('aturan-pakai');
    Route::get('tipe-barang', TipeBarang\Index::class)->name('tipe_barang');

    //gudang
    Route::get('supplier', Supplier\Index::class)->name('supplier');
    Route::get('product', Product\Index::class)->name('product');
    Route::get('faktur', Faktur\Index::class)->name('faktur');
    Route::get('faktur/form', Faktur\Form::class)->name('faktur-form');
    Route::get('faktur/{id}', Faktur\Detail::class)->name('faktur-detail');

    //transaksi
    Route::get('transaksi/non-resep', NonResepForm::class)->name('non-resep');
    Route::get('transaksi/resep', NonResepForm::class)->name('resep');
    Route::get('transaksi/laporan', LaporanNonResep::class)->name('laporan-transaksi');
    Route::get('transaksi/laporan/{id}', DetailNonResep::class)->name('detail-transaksi');
});
