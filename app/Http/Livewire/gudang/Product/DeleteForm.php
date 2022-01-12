<?php

namespace App\Http\Livewire\Gudang\Product;

use App\Models\Product;
use Livewire\Component;

class DeleteForm extends Component
{
    public $confirming, $nama_barang;
    protected $listeners = ['destroy', 'openDelete'];

    public function render()
    {
        return view('livewire.gudang.product.delete-form');
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

    public function destroy()
    {
        $product = Product::find($this->confirming);
        $productName = $product->name;
        $product->delete();
        $this->reset(['confirming', 'nama_barang']);
        $this->emit('toggleFormModalDelete');
        $this->dispatchBrowserEvent('refresh', ['message' => $productName . ' berhasil di hapus']);
    }
}
