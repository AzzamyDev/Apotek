<?php

namespace App\Http\Livewire\Gudang\Faktur;

use App\Models\Faktur;
use App\Models\Record;
use App\Models\OrderIn;
use App\Models\Product;
use Livewire\Component;

class Detail extends Component
{
    public $total_real, $supplier, $faktur, $list, $retur, $trx_id;
    public $edit = false;

    public function mount($id)
    {
        $faktur = Faktur::find($id);
        $this->list = OrderIn::where('faktur_id', $faktur->id)->get();
        $this->faktur = $faktur;
        $this->supplier = $faktur->supplier->name;
    }
    public function render()
    {
        $lists = $this->list;
        return view('livewire.gudang.faktur.detail')->with(compact('lists'));
    }
    public function edit($id)
    {
        $this->edit = true;
        $this->trx_id = $id;
    }

    public function update()
    {
        $product = Product::find($this->trx_id);
        $item = OrderIn::where('faktur_id', $this->faktur->id)
            ->where('product_id', $product->id)->first();

        if ($this->retur > $item->qty || $this->retur <= 0) {
            return $this->addError('stok', 'Masukan jumlah Retur dengan benar');
        }
        if ($this->retur > $product->stok) {
            return $this->addError('stok', 'Jumlah retur melebihi stok product ||' . $product->stok);
        }


        $product->stok -= $this->retur;
        $product->save();

        $subTotal_real = $item->harga_beli * ($item->qty - $this->retur);
        $diskon = ($item->diskon_real / 100) * $subTotal_real;
        $subTotal_real -= $diskon;

        $subTotal = $item->harga_beli * ($item->qty - $this->retur);
        $diskon_ = ($item->diskon / 100) * $subTotal;
        $subTotal -= $diskon_;


        $item->qty -= $this->retur;
        $item->sub_total -= $subTotal;
        $item->sub_total_real -= $subTotal_real;
        $item->save();

        $trx = Faktur::find($this->faktur->id);
        $trx->total = $trx->order->sum('sub_total');
        $trx->total_real = $trx->order->sum('sub_total_real');
        $trx->save();

        Record::create([
            'product_id' => $product->id,
            'qty' => $this->retur,
            'sisa_stok' => $product->stok,
            'record' => 'Out',
            'no_faktur' => $trx->no_faktur,
            'keterangan' => 'Retur Pembelian'
        ]);

        $this->resetInput();
        session()->flash('message', 'Retur berhasil.');
        $this->mount($this->faktur->id);
    }

    public function resetInput()
    {
        $this->retur = null;
        $this->edit = false;
        $this->trx_id = null;
    }
}
