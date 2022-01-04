<?php

namespace App\Http\Livewire\Gudang\Faktur;

use App\Models\Faktur;
use App\Models\OrderIn;
use Livewire\Component;

class Detail extends Component
{
    public $total_real, $supplier, $faktur, $list;

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
}
