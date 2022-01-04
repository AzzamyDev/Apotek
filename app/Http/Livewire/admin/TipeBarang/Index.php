<?php

namespace App\Http\Livewire\Admin\TipeBarang;

use App\Models\TipeBarang;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $tipe = TipeBarang::all();
        return view('livewire.admin.tipe-barang.index')->with(compact('tipe'));
    }
    public function destroy($id)
    {
        TipeBarang::find($id)->delete();
        return redirect()->route('tipe_barang')->with('success', 'Data berhasil di hapus');
    }
}
