<?php

namespace App\Http\Livewire\Gudang;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class WarningStok extends Component
{
    public function render()
    {
        $products = Product::where('status', 1)->where('stok', '<', DB::raw('products.min_stok'))->paginate(20);
        return view('livewire.gudang.warning-stok')->with(compact('products'));
    }
}
