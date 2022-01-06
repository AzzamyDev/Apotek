<?php

namespace App\Http\Livewire\Gudang\Faktur;

use App\Models\Faktur;
use App\Models\OrderIn;
use App\Models\Product;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\OrderInTemp;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $tanggal, $supplier, $no_faktur, $no_sp, $keterangan, $bayar, $tempo;
    public $product, $product_id, $batch, $expired, $harga_beli = 0, $diskon = 0, $qty;
    public $biaya_lain, $total, $total_real, $ppn, $grand_total;
    public $cari;

    protected $listeners = ['resetError'];

    public function render()
    {
        $suppliers = Supplier::orderBy('name', 'ASC')->get();

        // $this->init();
        if ($this->product == null) {
            $products = [];
            if (strlen($this->cari) >= 3) {
                $products = Product::where('name', 'like', '%' . $this->cari . '%')->take(10)->get();
            }
        } else {
            $products = [];
        }


        //Temp cart
        $temps = OrderInTemp::all();
        $this->total = OrderInTemp::all()->sum('sub_total');
        $this->total_real = OrderInTemp::all()->sum('sub_total_real');


        return view('livewire.gudang.faktur.form')->with(compact('products', 'temps', 'suppliers'));
    }

    public function mount()
    {
        OrderInTemp::truncate();
    }

    public function init()
    {

        $products = Product::where('name', $this->cari)->first();
        if ($products != null) {
            $this->product = $products;
            $this->product_id = $this->product->id;
            $this->harga_beli = $this->product->harga;
            $this->stok = $this->product->stok;
        }
    }

    public function updatedCari($cari)
    {
        $this->product = null;
        $this->stok = 0;
        $products = Product::where('name', $cari)->first();
        if ($products != null) {
            $this->product = $products;
            $this->product_id = $this->product->id;
            $this->harga_beli = $this->product->harga;
            $this->stok = $this->product->stok;
        }
    }

    public function resetError()
    {
        // $this->reset('harga_beli');
        // $this->resetValidation();
        $this->resetErrorBag();
    }

    public function addBarang()
    {
        $this->validate([
            'tanggal' => 'required',
            'supplier' => 'required',
            'no_faktur' => 'required',
            'no_sp' => 'required',
        ], [
            'tanggal.required' => 'Tanggal belum di isi',
            'supplier.required' => 'Supplier belum di isi',
            'no_faktur.required' => 'Nomer Faktur belum di isi',
            'no_sp.required' => 'Nomer SP belum di isi',
        ]);

        if ($this->bayar == 'Kredit') {
            $this->validate(['tempo' => 'required'], ['tempo.required' => 'Jatuh Tempo harus di isi']);
        }

        $this->validate([
            'batch' => 'required',
            'expired' => 'required',
            'harga_beli' => 'required',
            'qty' => 'required',
        ], [
            'cari.required' => 'Cari item dulu',
            'batch.required' => 'Batch belum di isi',
            'expired.required' => 'Expired belum di isi',
            'harga_beli.required' => 'Harga beli belum di isi',
            'qty.required' => 'Qty belum di isi',
        ]);

        $this->validate(['product_id' => 'unique:order_in_temps'], ['product_id.unique' => 'Product yang sama sudah ada']);

        if ($this->product_id == null) {
            return $this->addError('product_id', 'Set barang dulu');
        }

        $diskon_apotek = $this->diskon;
        if ($this->diskon == 5) {
            $diskon_apotek = 3;
        }
        if (in_array($this->diskon, range(5.0, 20.0, 0.1))) {
            $diskon_apotek = 5;
        }
        if (in_array($this->diskon, range(20.0, 100.0, 0.1))) {
            $diskon_apotek = $this->diskon / 2;
        }
        $subTotal_real = $this->harga_beli * $this->qty;
        $diskon = ($this->diskon != null ? $this->diskon : 0) / 100 * $subTotal_real;
        $subTotal_real -= $diskon;

        $subTotal = $this->harga_beli * $this->qty;
        $diskon_ = ($diskon_apotek != null ? $diskon_apotek : 0) / 100 * $subTotal;
        $subTotal -= $diskon_;

        OrderInTemp::create([
            'product_id' => $this->product->id,
            'nama_barang' => $this->product->name,
            'batch' => $this->batch,
            'expired' => $this->expired,
            'harga_beli' => $this->harga_beli,
            'diskon' => $diskon_apotek != null ? $diskon_apotek : 0,
            'diskon_real' => $this->diskon != null ? $this->diskon : 0,
            'qty' => $this->qty,
            'sub_total' => $subTotal,
            'sub_total_real' => $subTotal_real,
        ]);

        $this->resetCreateForm();
        $this->dispatchBrowserEvent('focus');
    }

    public function deleteCart($id)
    {
        $order = OrderInTemp::find($id);
        $order->delete();
        $this->dispatchBrowserEvent('refresh');
    }
    private function resetCreateForm()
    {
        $this->reset(['cari', 'harga_beli', 'diskon', 'batch', 'expired', 'qty', 'product']);
    }

    public function simpanTransaksi()
    {
        $this->validate([
            'tanggal' => 'required',
            'supplier' => 'required',
            'no_faktur' => 'required',
            'no_sp' => 'required',
        ], [
            'tanggal.required' => 'Tanggal belum di isi',
            'supplier.required' => 'Supplier belum di isi',
            'no_faktur.required' => 'Nomer Faktur belum di isi',
            'no_sp.required' => 'Nomer SP belum di isi',
        ]);

        if ($this->bayar == 'Kredit') {
            $this->validate(['tempo' => 'required'], ['tempo.required' => 'Jatuh Tempo harus di isi']);
        }

        $temps = OrderInTemp::all();

        $trx = Faktur::create([
            'supplier_id' => $this->supplier,
            'petugas_id' => Auth::user()->id,
            'no_faktur' => $this->no_faktur,
            'no_sp' => $this->no_sp,
            'tanggal' => $this->tanggal,
            'total' => $this->total,
            'total_real' => $this->total_real,
            'grand_total' => ($this->biaya_lain != null ? $this->biaya_lain : 0) + $this->ppn,
            'biaya_lain' => $this->biaya_lain != null ? $this->biaya_lain : 0,
            'items' => count($temps),
            'keterangan' => $this->keterangan != null ? $this->keterangan : null,
            'tempo' => $this->tempo != null ? $this->tempo : null,
            'bayar' => $this->bayar,
        ]);

        foreach ($temps as  $item) {
            $item['faktur_id'] = $trx->id;
            OrderIn::create($item->toArray());

            $product = Product::find($item->product_id);
            $product->stok += $item->qty;
            if ($item->harga_beli >= $product->harga) {
                $product->harga = $item->harga_beli;
            }
            if (!$product->status) {
                $product->status = true;
            }
            $product->save();
            Record::create([
                'product_id' => $item->product_id,
                'sisa_stok' => $product->stok,
                'no_faktur' => $trx->no_faktur,
                'record' => 'In'
            ]);
        }

        OrderInTemp::truncate();

        session()->flash('message', 'Faktur berhasil di simpan.');
        return redirect()->route('faktur');
    }
}
