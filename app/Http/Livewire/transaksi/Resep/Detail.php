<?php

namespace App\Http\Livewire\Transaksi\Resep;

use App\Models\Record;
use App\Models\Product;
use Livewire\Component;
use App\Models\OrderOut;
use App\Models\Transaction;

class Detail extends Component
{
    public $total, $transaksi, $list, $retur, $trx_id;
    public $edit = false;

    public function mount($id)
    {
        $faktur = Transaction::where('id', $id)->orWhere('no_transaksi', $id)->first();
        $this->list = OrderOut::where('transaksi_id', $faktur->id)->get();
        $this->transaksi = $faktur;
    }
    public function render()
    {
        $lists = $this->list;
        return view('livewire.transaksi.resep.detail')->with(compact('lists'));
    }
    public function edit($id)
    {
        $this->edit = true;
        $this->trx_id = $id;
    }

    public function update()
    {
        $product = Product::find($this->trx_id);
        if ($product->name != 'CEK KESEHATAN KOMPLIT') {

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
                'qty' => $this->retur,
                'sisa_stok' => $product->stok,
                'record' => 'In',
                'no_transaksi' => $trx->no_transaksi,
                'keterangan' => 'Retur Penjualan'
            ]);
        } else {
            $jasa = array('CEK ASAM URAT', 'CEK GULA DARAH', 'CEK KOLESTEROL', 'CEK TENSI DARAH');

            $item = OrderOut::where('transaksi_id', $this->transaksi->id)
                ->where('product_id', $product->id)->first();
            if ($this->retur > $item->qty || $this->retur <= 0) {
                return $this->addError('stok', 'Masukan jumlah Retur dengan benar');
            }
            $item->qty -= $this->retur;
            $item->sub_total -= $item->harga_jual * $this->retur;
            $item->save();

            $trx = Transaction::find($this->transaksi->id);
            $trx->total = $trx->order->sum('sub_total');
            $trx->save();

            for ($i = 0; $i < count($jasa); $i++) {
                $p = Product::where('name', $jasa[$i])->first();

                if ($p->name != 'CEK TENSI DARAH') {
                    $p->stok += $this->retur;
                    $p->save();
                }

                Record::create([
                    'product_id' => $p->id,
                    'qty' => $this->retur,
                    'sisa_stok' => $p->stok,
                    'record' => 'In',
                    'no_transaksi' => $trx->no_transaksi,
                    'keterangan' => 'Retur Penjualan'
                ]);
            }
        }

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
