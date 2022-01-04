<?php

namespace App\Http\Livewire\Gudang\Supplier;

use App\Models\Supplier;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $suppliers = Supplier::all();
        return view('livewire.gudang.supplier.index')->with(compact('suppliers'));
    }
    public function destroy($id)
    {
        Supplier::find($id)->delete();
        return redirect()->route('supplier')->with('success', 'Data berhasil di hapus');
    }
}
