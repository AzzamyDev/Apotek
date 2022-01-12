<?php

namespace App\Http\Livewire\Gudang\StokOpname;

use App\Models\DrafSo;
use Livewire\Component;
use App\Models\StokOpname;
use Livewire\WithPagination;

class Detail extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id_so, $tanggal;
    public function render()
    {
        $products = DrafSo::where('so_id', $this->id_so)->paginate(20);
        return view('livewire.gudang.stok-opname.detail')->with(compact('products'));
    }

    public function mount($id)
    {
        $this->id_so = $id;
        $this->tanggal = StokOpname::find($id)->created_at;
    }
}
