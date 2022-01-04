<?php

namespace App\Http\Livewire\Transaksi\NonResep;

use App\Models\OrderOut;
use App\Models\Transaction;
use Livewire\Component;

class Detail extends Component
{
    public $total, $supplier, $transaksi, $list;
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
}
