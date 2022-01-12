<?php

namespace App\Http\Livewire\Gudang;

use App\Models\Product;
use App\Models\Record as KartuStok;
use Livewire\Component;

class Record extends Component
{
    public $product, $product_id, $start, $end, $start_, $end_;
    protected $listeners = ['render'];
    public function render()
    {
        $records = KartuStok::whereBetween('created_at', array($this->start, $this->end))
            ->where('product_id', $this->product_id)
            ->orderBy('created_at', 'ASC')
            ->get();
        return view('livewire.gudang.record')->with(compact('records'));
    }

    public function mount($id)
    {
        $this->product_id = $id;
        $this->product = Product::find($id);
        $this->start = now()->startOfMonth()->startOfDay();
        $this->end = now()->endOfMonth()->endOfDay();
        $this->start_ = $this->start->format('d-m-Y H:i');
        $this->end_ = $this->end->format('d-m-Y H:i');
    }
}
