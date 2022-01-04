<?php

namespace App\Http\Livewire\Admin\JenisHarga;

use App\Models\JenisHarga;
use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.admin.jenis-harga.form');
    }

    public $name, $persentase, $jenis_id;
    protected $listeners = ['open' => 'loadHarga'];

    public function loadHarga($uid)
    {
        $this->resetErrorBag();
        $this->resetForm();
        $this->fill($uid ? JenisHarga::findOrFail($uid) : new JenisHarga);
        $this->jenis_id = $uid != '' ? $uid : '';
        // dd($this->jabatan);

        $this->emit('toggleFormModal');
    }

    public function resetForm()
    {
        $this->jenis_id = null;
        $this->name = '';
        $this->persentase = '';
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|unique:users',
            'persentase' => 'required',
        ]);

        JenisHarga::updateOrCreate(['id' => $this->jenis_id], [
            'name' => $this->name,
            'persentase' => $this->persentase,
        ]);

        $this->emit('toggleFormModal');
        return redirect()->route('harga')->with('success', 'Data berhasil di simpan');
    }
}
