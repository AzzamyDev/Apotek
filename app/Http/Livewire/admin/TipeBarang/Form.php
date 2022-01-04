<?php

namespace App\Http\Livewire\Admin\TipeBarang;

use App\Models\TipeBarang;
use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.admin.tipe-barang.form');
    }
    public $name, $tipe_id;
    protected $listeners = ['open' => 'loadTipe'];

    public function loadTipe($uid)
    {
        $this->resetErrorBag();
        $this->resetForm();
        $this->fill($uid ? TipeBarang::findOrFail($uid) : new TipeBarang);
        $this->tipe_id = $uid != '' ? $uid : '';
        // dd($this->jabatan);

        $this->emit('toggleFormModal');
    }

    public function resetForm()
    {
        $this->tipe_id = null;
        $this->name = '';
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
        ]);

        TipeBarang::updateOrCreate(['id' => $this->tipe_id], [
            'name' => $this->name,
        ]);

        $this->emit('toggleFormModal');
        return redirect()->route('tipe_barang')->with('success', 'Data berhasil di simpan');
    }
}
