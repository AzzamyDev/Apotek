<?php

namespace App\Http\Livewire\Gudang\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['render'];
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function openDelete($id)
    {
        $this->resetDelete();
        $this->confirming = $id;
        $p = Product::find($id);
        $this->nama_barang = $p->name;
        $this->emit('toggleFormModalDelete');
    }
    public function resetDelete()
    {
        $this->reset(['confirming', 'nama_barang']);
    }

    public function render()
    {
        $cari = '';
        if (strlen($this->search) >= 4) {
            $cari = $this->search;
        }
        $products = Product::where('name', 'like', '%' . $cari . '%')->paginate(20);
        return view('livewire.gudang.product.index')->with(compact('products'));
    }

    public function setStatus($id)
    {
        $product = Product::find($id);
        $product->status = !$product->status;
        $product->save();
        $this->dispatchBrowserEvent('refreshComponent', ['componentName' => '#table-1']);
    }
}
