<?php

use App\Http\Livewire\admin\Dokter\Index as DokterIndex;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\admin\Karyawan\Index as KaryawanIndex;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\AturanPakai\Index as AturanPakaiIndex;
use App\Http\Livewire\admin\JenisHarga\Index as JenisHargaIndex;
use App\Http\Livewire\Admin\TipeBarang\Index as TipeBarangIndex;
use App\Http\Livewire\App\Home;
use App\Http\Livewire\Gudang\Product\Index as ProductIndex;
use App\Http\Livewire\Gudang\Supplier\Index as SupplierIndex;
use App\Http\Livewire\Gudang\Faktur\Index as FakturIndex;
use App\Http\Livewire\Gudang\Faktur\Form as FakturForm;
use App\Http\Livewire\Gudang\Faktur\Detail as FakturDetail;
use App\Http\Livewire\Transaksi\NonResep\Form as NonResepForm;
use App\Http\Livewire\Transaksi\NonResep\Laporan as LaporanNonResep;
use App\Http\Livewire\Transaksi\NonResep\Detail as DetailNonResep;
use App\Http\Livewire\Transaksi\NonResep\ListTransaksi;

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
    Route::get('karyawan', KaryawanIndex::class)->name('karyawan');
    Route::get('dokter', DokterIndex::class)->name('dokter');
    Route::get('harga', JenisHargaIndex::class)->name('harga');
    Route::get('aturan-pakai', AturanPakaiIndex::class)->name('aturan-pakai');
    Route::get('tipe-barang', TipeBarangIndex::class)->name('tipe_barang');

    //gudang
    Route::get('supplier', SupplierIndex::class)->name('supplier');
    Route::get('product', ProductIndex::class)->name('product');
    Route::get('faktur', FakturIndex::class)->name('faktur');
    Route::get('faktur/form', FakturForm::class)->name('faktur-form');
    Route::get('faktur/{id}', FakturDetail::class)->name('faktur-detail');

    //transaksi
    Route::get('transaksi/non-resep', NonResepForm::class)->name('non-resep');
    Route::get('transaksi/resep', NonResepForm::class)->name('resep');
    Route::get('transaksi/list', ListTransaksi::class)->name('list-transaksi');
    Route::get('transaksi/laporan', LaporanNonResep::class)->name('laporan-transaksi');
    Route::get('transaksi/laporan/{id}', DetailNonResep::class)->name('detail-transaksi');
});
