<?php

namespace App\Http\Livewire\Gudang\Faktur;

use App\Models\Faktur;
use Livewire\Component;

class Index extends Component
{
    public $start, $end;
    public $cari;

    public function render()
    {
        $fakturs = null;
        if ($this->cari != null) {
            $fakturs = Faktur::where('no_faktur', $this->cari)
                ->orWhere('no_sp', $this->cari)->paginate(10);
        } else {
            $fakturs = Faktur::whereBetween('tanggal', array($this->start, $this->end))->paginate(10);
        }
        return view('livewire.gudang.faktur.index')->with(compact('fakturs'));
    }

    public function mount()
    {
        $this->start = now()->startOfDay();
        $this->end = now()->endOfDay();
        $this->reset('cari');
    }
}
