<?php

namespace App\Http\Livewire\Gudang;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class StokOpname extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['render'];
    public $search = '', $qty;

    public function render()
    {
        $cari = '';
        if (strlen($this->search) >= 4) {
            $cari = $this->search;
        }
        $products = Product::where('name', 'like', '%' . $cari . '%')->paginate(20);
        return view('livewire.gudang.stok-opname');
    }

    public function setStok($id)
    {
        $product = Product::find($id);
        $product->stok = $this->qty;
        $product->save();
        $this->reset('qty');
        $this->emit('render');
        // $this->dispatchBrowserEvent('refreshComponent');
    }
}
