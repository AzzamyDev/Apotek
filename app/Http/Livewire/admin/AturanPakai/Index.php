<?php

namespace App\Http\Livewire\Admin\AturanPakai;

use Livewire\Component;
use App\Models\AturanPakai;

class Index extends Component
{
    public function render()
    {
        $aturan = AturanPakai::all();
        return view('livewire.admin.aturan-pakai.index')->with(compact('aturan'));
    }
    public function destroy($id)
    {
        AturanPakai::find($id)->delete();
        return redirect()->route('aturan-pakai')->with('success', 'Data berhasil di hapus');
    }
}
