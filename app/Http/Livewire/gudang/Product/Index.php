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

    public function render()
    {
        $cari = '';
        if (strlen($this->search) >= 4) {
            $cari = $this->search;
        }
        $products = Product::where('name', 'like', '%' . $cari . '%')->paginate(50);
        return view('livewire.gudang.product.index')->with(compact('products'));
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        $productName = $product->name;
        $product->delete();
        $this->dispatchBrowserEvent('refresh', ['message' => $productName . ' berhasil di hapus']);
    }
    public function setStatus($id)
    {
        $product = Product::find($id);
        $product->status = !$product->status;
        $product->save();
        $this->dispatchBrowserEvent('refreshComponent', ['componentName' => '#table-1']);
    }
}
