<?php

namespace App\Http\Livewire\Transaksi\Resep;

use App\Models\Record;
use App\Models\Product;
use App\Models\Racikan;
use Livewire\Component;
use App\Models\OrderOut;
use App\Models\JenisHarga;
use App\Models\AturanPakai;
use App\Models\ItemRacikan;
use App\Models\RacikanTemp;
use App\Models\OrderOutTemp;
use App\Models\ItemRacikanTemp;

class FormRacikan extends Component
{
    public $total, $product, $product_id, $stok, $search, $name, $sediaan, $aturan,
        $harga_beli, $qty,  $jenis_harga, $no_resep;

    public $listeners = ['open', 'fresh' => '$refresh'];
    public function render()
    {
        $aturans = AturanPakai::all();
        if ($this->product == null) {
            $products = [];
            if (strlen($this->search) >= 3) {
                $products = Product::where('name', 'like', '%' . $this->search . '%')
                    ->where('status', 1)->take(10)->get();
            }
        } else {
            $products = [];
        }

        $temps = ItemRacikanTemp::all();
        $this->total = ItemRacikanTemp::all()->sum('sub_total');
        $harga = JenisHarga::where('name', 'Resep')->get();

        return view('livewire.transaksi.resep.form-racikan')->with(compact(['products', 'temps', 'harga', 'aturans']));
    }

    public function mount()
    {

        ItemRacikanTemp::truncate();
    }

    public function updatedSearch($search)
    {
        $this->resetForm();
        $products = Product::where('name', $search)->first();
        if ($products != null) {
            $this->product = $products;
            $this->product_id = $this->product->id;
            $this->harga_beli = ceil($this->product->harga * 1.1);
            $this->stok = $this->product->stok;
        }
    }
    public function open($val)
    {
        $this->no_resep = $val;
        $this->emit('toggleFormModal');
    }

    public function resetForm()
    {
        $this->reset(['product_id', 'product',  'qty', 'harga_beli', 'jenis_harga']);
    }

    public function resetModal()
    {
        $this->reset(['product_id', 'product',  'qty', 'harga_beli', 'jenis_harga', 'search']);
    }
    public function resetError()
    {
        $this->resetErrorBag();
    }

    public function deleteItem($id)
    {
        $order = ItemRacikanTemp::find($id);
        $order->delete();
    }

    public function pembulatan($t)
    {
        if (strlen($t) > 3) {
            $nominal = substr($t, -3);
            $t -= $nominal;
            if ($nominal > 750) {
                return $t += 1000;
            }
            if ($nominal > 250 && $nominal < 750) {
                return $t += 500;
            }
            if ($nominal < 250 && $nominal > 0) {
                return $t += 0;
            }
        } else {
            $nominal = substr($t, -2);
            $t -= $nominal;
            if ($nominal > 75) {
                return $t += 100;
            }
            if ($nominal > 25 && $nominal < 75) {
                return $t += 50;
            }
            if ($nominal < 25 && $nominal > 0) {
                return $t += 0;
            }
        }
    }

    public function addBarang()
    {
        if ($this->product_id == null) {
            return $this->addError('product_id', 'Set barang dulu');
        }

        $this->validate([
            'qty' => 'required',
        ], [
            'qty.required' => 'Qty belum di isi',
        ]);

        $this->validate(['product_id' => 'unique:item_racikan_temps'], ['product_id.unique' => 'Product yang sama sudah ada']);


        if ($this->qty > $this->stok) {
            return $this->addError('product_id', 'Stok tidak mencukupi');
        }


        $j_harga = JenisHarga::where('name', 'Resep')->first();
        $hna = $this->product->harga;
        $hna_ppn = $hna * 1.1;
        $H = $hna_ppn * (1 + ($j_harga->persentase / 100));

        $harga_final = $this->pembulatan(ceil($H));

        ItemRacikanTemp::create([
            'product_id' => $this->product->id,
            'nama_barang' => $this->product->name,
            'qty' => $this->qty,
            'jenis_harga_id' => $j_harga->id,
            'harga_beli' => $hna,
            'harga_jual' => $harga_final,
            'sub_total' => $this->qty * $harga_final,
        ]);

        $this->resetModal();
        $this->emit('fresh');
    }

    public function simpanTransaksi()
    {
        $racikan = RacikanTemp::create([
            'nama_racikan' => $this->name,
            'sediaan' => $this->sediaan,
            'aturan' => $this->aturan,
            'total' => $this->total,
        ]);

        $temps = ItemRacikanTemp::all();

        foreach ($temps as $item) {
            $item['racikan_id'] = $racikan->id;
            ItemRacikan::create($item->toArray());
        }

        ItemRacikanTemp::truncate();
        $this->emit('toggleFormModal');
        $this->emitTo('transaksi.resep.form', 'fresh');
    }
}
