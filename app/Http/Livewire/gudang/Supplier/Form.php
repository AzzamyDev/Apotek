<?php

namespace App\Http\Livewire\Gudang\Supplier;

use App\Models\Supplier;
use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.gudang.supplier.form');
    }
    public $name, $telepon, $alamat, $supplier_id;
    protected $listeners = ['open' => 'loadSupplier'];

    public function loadSupplier($uid)
    {
        $this->resetErrorBag();
        $this->resetForm();
        $this->fill($uid ? Supplier::findOrFail($uid) : new Supplier);
        $this->supplier_id = $uid != '' ? $uid : '';
        // dd($this->jabatan);

        $this->emit('toggleFormModal');
    }

    public function resetForm()
    {
        $this->supplier_id = null;
        $this->name = '';
        $this->telepon = '';
        $this->alamat = '';
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
        ]);

        Supplier::updateOrCreate(['id' => $this->supplier_id], [
            'name' => $this->name,
            'telepon' => $this->telepon,
            'alamat' => $this->alamat,
        ]);

        $this->emit('toggleFormModal');
        return redirect()->route('supplier')->with('success', 'Data berhasil di simpan');
    }
}
