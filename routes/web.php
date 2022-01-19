<?php

use App\Http\Livewire\admin\Dokter\Index as DokterIndex;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\admin\Karyawan\Index as KaryawanIndex;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\admin\AturanPakai\Index as AturanPakaiIndex;
use App\Http\Livewire\admin\JenisHarga\Index as JenisHargaIndex;
use App\Http\Livewire\admin\TipeBarang\Index as TipeBarangIndex;
use App\Http\Livewire\App\Home;
use App\Http\Livewire\gudang\Product\Index as ProductIndex;
use App\Http\Livewire\gudang\Supplier\Index as SupplierIndex;
use App\Http\Livewire\gudang\Faktur\Index as FakturIndex;
use App\Http\Livewire\gudang\Faktur\Form as FakturForm;
use App\Http\Livewire\gudang\Faktur\Detail as FakturDetail;
use App\Http\Livewire\gudang\Record as KartuStok;
use App\Http\Livewire\gudang\Stok;
use App\Http\Livewire\Gudang\WarningStok;
use App\Http\Livewire\Gudang\StokOpname\Index as StokOpnameIndex;
use App\Http\Livewire\Gudang\StokOpname\Form as StokOpnameForm;
use App\Http\Livewire\Gudang\StokOpname\Detail as StokOpnameDetail;
use App\Http\Livewire\Gudang\StokOpname\Nilai as StokOpnameNilai;
use App\Http\Livewire\Gudang\StokOpname\Nbh as StokOpnameNbh;
use App\Http\Livewire\transaksi\Resep\Form as ResepForm;
use App\Http\Livewire\transaksi\Resep\Laporan as LaporanResep;
use App\Http\Livewire\transaksi\Resep\Detail as DetailResep;
use App\Http\Livewire\transaksi\NonResep\Form as NonResepForm;
use App\Http\Livewire\transaksi\NonResep\Laporan as LaporanNonResep;
use App\Http\Livewire\transaksi\NonResep\Detail as DetailNonResep;
use App\Http\Livewire\transaksi\NonResep\ListTransaksi as ListTransaksiNonResep;

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
    Route::get('product/warning', WarningStok::class)->name('warning-stok');
    Route::get('stok-opname', StokOpnameIndex::class)->name('index-opname');
    Route::get('stok-opname/{id}', StokOpnameForm::class)->name('form-opname');
    Route::get('stok-opname/{id}/detail', StokOpnameDetail::class)->name('detail-opname');
    Route::get('stok-opname/{id}/nilai', StokOpnameNilai::class)->name('nilai-opname');
    Route::get('stok-opname/{id}/nbh', StokOpnameNbh::class)->name('nbh-opname');
    Route::get('faktur', FakturIndex::class)->name('faktur');
    Route::get('faktur/form', FakturForm::class)->name('faktur-form');
    Route::get('faktur/{id}', FakturDetail::class)->name('faktur-detail');
    Route::get('faktur/{no_trx}', FakturDetail::class)->name('to-faktur');
    Route::get('record/{id}', KartuStok::class)->name('record');

    //Apotek

    //Resep
    Route::get('transaksi/non-resep', NonResepForm::class)->name('non-resep');
    Route::get('transaksi/resep', ResepForm::class)->name('resep');
    Route::get('transaksi/resep/laporan', LaporanResep::class)->name('laporan-transaksi-resep');
    Route::get('transaksi/resep/laporan/{id}', DetailResep::class)->name('detail-transaksi-resep');
    //Non-Resep
    Route::get('transaksi/non-resep/list', ListTransaksiNonResep::class)->name('list-transaksi');
    Route::get('transaksi/non-resep/laporan', LaporanNonResep::class)->name('laporan-transaksi');
    Route::get('transaksi/non-resep/laporan/{id}', DetailNonResep::class)->name('detail-transaksi');
    Route::get('transaksi/non-resep/laporan/{no_trx}', DetailNonResep::class)->name('to-trx');
    //stok
    Route::get('stok', Stok::class)->name('stok');
    Route::get('print/{trx}', function () {
        return view('helper.form.print_struk');
    })->name('print');
});
