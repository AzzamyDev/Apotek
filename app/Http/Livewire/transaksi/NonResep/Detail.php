<?php

namespace App\Http\Livewire\Transaksi\NonResep;

use App\Models\OrderIn;
use App\Models\OrderOut;
use App\Models\Product;
use App\Models\Record;
use App\Models\Transaction;
use Livewire\Component;

class Detail extends Component
{
    public $total, $supplier, $transaksi, $list, $retur, $trx_id;
    public $edit = false;

    public function mount($id)
    {
        $faktur = Transaction::find($id);
        $this->list = OrderOut::where('transaksi_id', $faktur->id)->get();
        $this->transaksi = $faktur;
    }
    public function render()
    {
        $lists = $this->list;
        return view('livewire.transaksi.non-resep.detail')->with(compact('lists'));
    }
    public function edit($id)
    {
        $this->edit = true;
        $this->trx_id = $id;
    }

    public function update()
    {
        $product = Product::find($this->trx_id);
        $item = OrderOut::where('transaksi_id', $this->transaksi->id)
            ->where('product_id', $product->id)->first();

        if ($this->retur > $item->qty || $this->retur <= 0) {
            return $this->addError('stok', 'Masukan jumlah Retur dengan benar');
        }

        $product->stok += $this->retur;
        $product->save();

        $item->qty -= $this->retur;
        $item->sub_total -= $item->harga_jual * $this->retur;
        $item->save();

        $trx = Transaction::find($this->transaksi->id);
        $trx->total = $trx->order->sum('sub_total');
        $trx->save();

        Record::create([
            'product_id' => $product->id,
            'sisa_stok' => $product->stok,
            'record' => 'In',
            'no_transaksi' => $trx->no_transaksi
        ]);

        $this->edit = false;
        $this->trx_id = null;
        session()->flash('message', 'Retur berhasil.');
        $this->mount($this->transaksi->id);
    }

    public function resetInput()
    {
        $this->retur = null;
        $this->edit = false;
    }
}
