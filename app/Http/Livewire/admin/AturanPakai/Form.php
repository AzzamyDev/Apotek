<?php

namespace App\Http\Livewire\Admin\AturanPakai;

use Livewire\Component;
use App\Models\AturanPakai;

class Form extends Component
{
    public function render()
    {
        return view('livewire.admin.aturan-pakai.form');
    }

    public $name, $aturan_id;
    protected $listeners = ['open' => 'loadAturan'];

    public function loadAturan($uid)
    {
        $this->resetErrorBag();
        $this->resetForm();
        $this->fill($uid ? AturanPakai::findOrFail($uid) : new AturanPakai);
        $this->aturan_id = $uid != '' ? $uid : '';
        // dd($this->jabatan);

        $this->emit('toggleFormModal');
    }

    public function resetForm()
    {
        $this->aturan_id = null;
        $this->name = '';
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
        ]);

        AturanPakai::updateOrCreate(['id' => $this->aturan_id], [
            'name' => $this->name,
        ]);

        $this->emit('toggleFormModal');
        return redirect()->route('aturan-pakai')->with('success', 'Data berhasil di simpan');
    }
}
