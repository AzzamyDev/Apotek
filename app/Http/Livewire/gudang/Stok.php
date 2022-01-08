<?php

namespace App\Http\Livewire\Gudang;

use App\Models\Product;
use Livewire\Component;
use App\Models\TipeBarang;
use Livewire\WithPagination;

class Stok extends Component
{
    public $type, $search,  $total_barang;
    private $products;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $tipe = TipeBarang::all();
        $products = Product::where('status', 1)->where('name', 'like', '%' . $this->search . '%')->paginate(20);
        $data = Product::where('status', 1)->where('name', 'like', '%' . $this->search . '%')->get();
        if ($this->type != null) {
            $data = Product::where('status', 1)->where('tipe_barang_id', $this->type)->where('name', 'like', '%' . $this->search . '%')->get();
            $products = Product::where('status', 1)->where('tipe_barang_id', $this->type)->where('name', 'like', '%' . $this->search . '%')->paginate(20);
        }
        $this->total_barang = $data->count();
        return view('livewire.gudang.stok')->with(compact(['tipe', 'products']));
    }

    public function mount()
    {
        $this->reset('type');
    }
}
