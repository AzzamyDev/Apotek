<?php

namespace App\Http\Livewire\Gudang\Product;

use App\Models\JenisHarga;
use App\Models\Product;
use App\Models\Satuan;
use App\Models\TipeBarang;
use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        $tipe_barang = TipeBarang::all();
        $tipe_harga = JenisHarga::all();
        $satuans = Satuan::orderBy('name', 'ASC')->get();
        return view('livewire.gudang.product.form')->with(compact(['tipe_harga', 'tipe_barang', 'satuans']));
    }


    public $name, $golongan, $tipe_barang_id, $tipe_harga_id, $lokasi, $satuan, $harga, $product_id, $min_stok, $max_stok;
    protected $listeners = ['open' => 'loadProduct'];
    protected $messages = [
        'name.required' => 'Nama tidak boleh kosong.',
        'harga.required' => 'Harga tidak boleh kosong.',
        'lokasi.required' => 'Lokasi Rak tidak boleh kosong.',
        'golongan.required' => 'Pilih Golongan obat.',
        'tipe_barang_id.required' => 'Pilih Tipe Barang obat.',
        'tipe_harga_id.required' => 'Pilih Tipe Harga obat.',
        'satuan.required' => 'Pilih Satuan obat.',
    ];

    public function loadProduct($uid)
    {
        $this->resetErrorBag();
        $this->resetForm();
        $this->fill($uid ? Product::findOrFail($uid) : new Product);
        $this->product_id = $uid != '' ? $uid : '';
        // dd($this->jabatan);

        $this->emit('toggleFormModal');
    }

    public function resetForm()
    {
        $this->product_id = null;
        $this->name = '';
        $this->golongan = null;
        $this->lokasi = '';
        $this->harga = null;
        $this->satuan = null;
        $this->tipe_barang_id = null;
        $this->tipe_harga_id = null;
    }

    public function submit()
    {
        if ($this->product_id == null) {
            $this->validate([
                'name' => 'required|unique:products',
                'golongan' => 'required',
                'harga' => 'required',
                'satuan' => 'required',
                'tipe_barang_id' => 'required',
                'tipe_harga_id' => 'required',
            ]);
        }
        $this->validate([
            'name' => 'required',
            'golongan' => 'required',
            'harga' => 'required',
            'satuan' => 'required',
            'tipe_barang_id' => 'required',
            'tipe_harga_id' => 'required',
        ]);

        Product::updateOrCreate(['id' => $this->product_id], [
            'name' => $this->name,
            'golongan' => $this->golongan,
            'harga' => $this->harga,
            'satuan' => $this->satuan,
            'tipe_barang_id' => $this->tipe_barang_id,
            'tipe_harga_id' => $this->tipe_harga_id,
            'lokasi' => $this->lokasi,
            'min_stok' => $this->min_stok,
            'max_stok' => $this->max_stok,
        ]);

        $this->emit('toggleFormModal');
        $this->dispatchBrowserEvent('save', ['save' => 'Data berhasil di simpan']);
        //return redirect()->route('product')->with('success', 'Data berhasil di simpan');
    }
}
