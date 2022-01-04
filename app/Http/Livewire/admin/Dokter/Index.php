<?php

namespace App\Http\Livewire\Admin\Dokter;

use App\Models\Dokter;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $dokters = Dokter::orderBy('name', 'ASC')->get();
        return view('livewire.admin.dokter.index')->with(compact('dokters'));
    }
    public function destroy($id)
    {
        Dokter::find($id)->delete();
        return redirect()->route('dokter')->with('success', 'Data berhasil di hapus');
    }
}
