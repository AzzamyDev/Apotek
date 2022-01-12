<?php

namespace App\Http\Livewire\Gudang\StokOpname;

use App\Models\DrafSo;
use App\Models\Product;
use App\Models\StokOpname;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Form extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh' => '$refresh'];
    public $search = '', $qty, $id_so;

    public function render()
    {
        $cari = '';
        if (strlen($this->search) >= 4) {
            $cari = $this->search;
        }
        $products = DrafSo::where('so_id', $this->id_so)
            ->where('name', 'like', '%' . $cari . '%')->paginate(20);
        return view('livewire.gudang.stok-opname.form')->with(compact('products'));
    }

    public function mount($id)
    {
        $this->id_so = $id;
    }

    public function save($id)
    {
        if ($this->qty != null) {
            $draf = DrafSo::find($id);
            if ($draf->status == 0) {
                $draf->status = true;
            }
            $draf->stok_akhir = $this->qty;

            $p_id = $draf->product_id;
            $product = Product::find($p_id);
            $product->stok = $this->qty;

            $product->save();
            $draf->save();

            $this->reset('qty');
            $this->emit('refresh');
        }
    }

    public function simpan()
    {
        $products = DrafSo::where('so_id', $this->id_so)->get();
        foreach ($products as $item) {
            $draf = DrafSo::find($item->id);
            if ($draf->status == 0) {
                $draf->status = true;
                $draf->stok_akhir = 0;
                $draf->save();

                $p_id = $draf->product_id;
                $product = Product::find($p_id);
                $product->stok = 0;
                $product->save();
            }
        }

        $so = StokOpname::find($this->id_so);
        $so->status = 'Close';
        $so->waktu_close = now();
        $so->save();
        session()->flash('message', 'Stok Opname berhasil di simpan.');
        return redirect()->route('index-opname');
    }
}
