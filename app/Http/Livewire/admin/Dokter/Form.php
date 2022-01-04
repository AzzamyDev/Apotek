<?php

namespace App\Http\Livewire\Admin\Dokter;

use App\Models\Dokter;
use Livewire\Component;

class Form extends Component
{
    public function render()
    {

        return view('livewire.admin.dokter.form');
    }

    public $name, $telepon, $status, $dokter_id;
    protected $listeners = ['open' => 'loadDokter'];

    protected $rules = [
        'name' => 'required|unique:users',
        'telepon' => 'required',
    ];

    public function loadDokter($uid)
    {
        $this->resetErrorBag();
        $this->resetForm();
        $this->fill($uid ? Dokter::findOrFail($uid) : new Dokter);
        $this->dokter_id = $uid != '' ? $uid : '';
        // dd($this->jabatan);

        $this->emit('toggleFormModal');
    }

    public function resetForm()
    {
        $this->dokter_id = null;
        $this->name = '';
        $this->telepon = '';
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'telepon' => 'required',
        ]);

        $status = '';
        if ($this->status) {
            $status = 'Active';
        } else {
            $status = 'Non Active';
        }

        Dokter::updateOrCreate(['id' => $this->dokter_id], [
            'name' => $this->name,
            'telepon' => $this->telepon,
            'status' => $this->dokter_id != null ? $status : 'Active',
        ]);

        $this->emit('toggleFormModal');
        return redirect()->route('dokter')->with('success', 'Data berhasil di simpan');
    }
}
