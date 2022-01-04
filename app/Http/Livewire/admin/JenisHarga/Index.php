<?php

namespace App\Http\Livewire\Admin\JenisHarga;

use App\Models\JenisHarga;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $jenis = JenisHarga::all();
        return view('livewire.admin.jenis-harga.index')->with(compact('jenis'));
    }

    public function destroy($id)
    {
        $harga = JenisHarga::find($id);
        $harga->delete();
        return redirect()->route('harga')->with('success', 'Data berhasil di hapus');
    }
}
