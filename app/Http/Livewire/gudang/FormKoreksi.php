<?php

namespace App\Http\Livewire\Gudang;

use App\Models\Product;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormKoreksi extends Component
{
    public $product_id, $qty, $alasan, $keterangan;
    protected $listeners = ['open' => 'loadProduct'];
    protected $messages = [
        'qty.required' => 'Jumlah koreksi tidak boleh kosong.',
        'alasan.required' => 'Pilih Alasan dulu.',
        'keterangan.required' => 'Keterangan tidak boleh kosong.',
    ];
    public function render()
    {
        return view('livewire.gudang.form-koreksi');
    }

    public function loadProduct($uid)
    {
        $this->resetErrorBag();
        $this->resetForm();
        $this->product_id = $uid;

        $this->emit('toggleFormModal');
    }

    public function resetForm()
    {
        $this->reset(['qty', 'product_id', 'keterangan', 'alasan']);
    }

    public function submit()
    {
        if ($this->product_id != null) {
            $this->validate([
                'qty' => 'required',
                'alasan' => 'required',
            ]);
            if ($this->alasan == 'Lainnya') {
                $this->validate([
                    'keterangan' => 'required',
                ]);
            }

            $product = Product::find($this->product_id);
            $product->stok = $this->qty;
            $product->save();

            Record::create([
                'product_id' => $this->product_id,
                'record' => 'Koreksi',
                'qty' => $this->qty,
                'sisa_stok' => $product->stok,
                'keterangan' => Auth::user()->name . '-' . $this->alasan . '-' . $this->keterangan,
            ]);
            $this->emit('toggleFormModal');
            $this->dispatchBrowserEvent('save', ['save' => 'Data berhasil di simpan']);
            //return redirect()->route('product')->with('success', 'Data berhasil di simpan');
        }
    }
}
