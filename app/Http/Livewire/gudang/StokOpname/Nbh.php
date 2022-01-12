<?php

namespace App\Http\Livewire\Gudang\StokOpname;

use App\Models\DrafSo;
use Livewire\Component;
use App\Models\StokOpname;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Nbh extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id_so, $tanggal, $total;
    public function render()
    {
        $products = DrafSo::where('so_id', $this->id_so)->paginate(20);
        return view('livewire.gudang.stok-opname.nbh')->with(compact('products'));
    }

    public function mount($id)
    {
        $this->id_so = $id;
        $this->tanggal = StokOpname::find($id)->created_at;
        $products = DrafSo::where('so_id', $this->id_so)
            ->select(DB::raw('sum(harga*(stok_terakhir-stok_akhir)) AS total'));
        $this->total = $products->first()->total;
    }
}
