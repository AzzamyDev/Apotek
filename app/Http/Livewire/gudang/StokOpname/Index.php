<?php

namespace App\Http\Livewire\Gudang\StokOpname;

use App\Models\DrafSo;
use App\Models\Product;
use Livewire\Component;
use App\Models\StokOpname;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // whereBetween('created_at', array($this->start, $this->end))
    public $start, $end, $start_, $end_, $id_so;
    public function render()
    {
        $opname = StokOpname::whereBetween('created_at', array($this->start, $this->end))->paginate(5);
        return view('livewire.gudang.stok-opname.index')->with(compact('opname'));
    }

    public function mount()
    {
        $this->start = now()->firstOfMonth()->startOfDay();
        $this->end = now()->endOfMonth()->endOfDay();
        $this->start_ = now()->firstOfMonth()->startOfDay()->format('d-m-Y H:i');
        $this->end_ = now()->endOfMonth()->endOfDay()->format('d-m-Y H:i');
    }

    public function create()
    {
        $so = StokOpname::create([
            'petugas_id' => Auth::user()->id,
        ]);

        $products = Product::where('status', 1)->get();

        foreach ($products as $item) {
            DrafSo::create([
                'so_id' => $so->id,
                'product_id' => $item->id,
                'name' => $item->name,
                'harga' => $item->harga,
                'stok_terakhir' => $item->stok,
            ]);
        }
    }

    public function open($id)
    {
        $this->reset('id_so');
        $this->id_so = $id;
        $this->emit('toggleFormModalDelete');
    }

    public function resetDelete()
    {
        $this->reset('id_so');
    }

    public function deleteDraf()
    {
        DrafSo::where('so_id', $this->id_so)->delete();
        $so = StokOpname::find($this->id_so);
        $so->status = 'Cancel';
        $so->save();
        $this->emit('toggleFormModalDelete');
        $this->dispatchBrowserEvent('refresh', ['message' => 'Draft SO berhasil di batalkan']);
    }
}
