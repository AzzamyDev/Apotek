<?php

namespace App\Http\Livewire\Transaksi\NonResep;

use Carbon\Carbon;
use App\Models\Shift;
use App\Models\Record;
use App\Models\Product;
use Livewire\Component;
use App\Models\OrderOut;
use App\Models\JenisHarga;
use App\Models\Transaction;
use App\Models\OrderOutTemp;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $total, $product, $product_id, $stok, $cari, $harga_beli, $qty, $keterangan, $tanggal;
    public $jumlahBayar, $tipe_bayar, $bayar, $shift, $no_transaksi, $jenis_harga, $tipe_transaksi, $customer;
    public $kembalian = 0;
    protected $listeners = ['resetError'];

    public function render()
    {
        $jenisHarga = JenisHarga::all();
        if ($this->product == null) {
            $products = [];
            if (strlen($this->cari) >= 3) {
                $products = Product::where('name', 'like', '%' . $this->cari . '%')
                    ->where('status', 1)->take(10)->get();
            }
        } else {
            $products = [];
        }

        $temps = OrderOutTemp::all();
        $this->total = OrderOutTemp::all()->sum('sub_total');
        $harga = JenisHarga::all();

        return view('livewire.transaksi.non-resep.form')->with(compact(['products', 'jenisHarga', 'temps', 'harga']));
    }

    public function pembulatan($t)
    {
        $nominal = substr($t, -3);
        $t -= $nominal;
        if ($nominal > 750) {
            return $t += 1000;
        }
        if ($nominal > 250 && $nominal < 750) {
            return $t += 500;
        }
        if ($nominal < 250 && $nominal > 0) {
            return $t += 0;
        }
    }

    public function mount()
    {
        $this->tipe_bayar = 'Tunai';
        $this->tipe_transaksi = 'Umum';

        //--------------------------//
        $now = Carbon::now();
        $shifts = Shift::all();
        foreach ($shifts as $item) {
            $start = Carbon::createFromFormat('h:i A', $item->start);
            $end =  Carbon::createFromFormat('h:i A', $item->end);
            if ($item->end == '07:00 AM') {
                $start = Carbon::createFromFormat('h:i A', '00:00 AM');
            }
            if ($now->isBetween($start, $end)) {
                $this->shift = $item->name;
            }
        }

        $this->no_transaksi = substr(strtoupper(uniqid()), -5) . '-' . rand(1000, 9999);
        $this->dispatchBrowserEvent('focus');
    }

    public function updatedCari($cari)
    {
        $this->resetCreateForm();
        $products = Product::where('name', $cari)->first();
        if ($products != null) {
            $this->product = $products;
            $this->product_id = $this->product->id;
            $this->harga_beli = ceil($this->product->harga * 1.1);
            $this->stok = $this->product->stok;
        }
    }

    public function updatedJumlahBayar($val)
    {
        if ($val > 0) {
            $this->kembalian = $val - $this->total;
        } else {
            $this->kembalian = 0;
        }
    }

    public function updatedTipeBayar($val)
    {
        if ($val == 'Tunai') {
            $this->bayar = null;
        }
    }
    public function updatedTipeTransaksi($val)
    {
        if ($val != 'Halodoc') {
            $this->customer = null;
        }
    }

    public function addBarang()
    {
        if ($this->product_id == null) {
            return $this->addError('product_id', 'Set barang dulu');
        }

        $this->validate([
            'qty' => 'required',
            // 'jenis_harga' => 'required',
        ], [
            'qty.required' => 'Qty belum di isi',
            // 'jenis_harga.required' => 'Pilih jenis harga',
        ]);

        $this->validate(['product_id' => 'unique:order_out_temps'], ['product_id.unique' => 'Product yang sama sudah ada']);


        if ($this->qty > $this->stok) {
            return $this->addError('product_id', 'Stok tidak mencukupi');
        }

        // $j_harga = JenisHarga::find($this->jenis_harga);
        $j_harga = $this->product->jenisHarga;
        $hna = $this->product->harga;
        $hna_ppn = $hna * 1.1;
        $H = $hna_ppn * (1 + ($j_harga->persentase / 100));

        $harga_final = $this->pembulatan(ceil($H));

        OrderOutTemp::create([
            'product_id' => $this->product->id,
            'nama_barang' => $this->product->name,
            'qty' => $this->qty,
            'jenis_harga_id' => $j_harga->id,
            'harga_beli' => $hna,
            'harga_jual' => $harga_final,
            'sub_total' => $this->qty * $harga_final,
        ]);

        $this->reset('cari');
        $this->resetCreateForm();
        $this->dispatchBrowserEvent('focus');
    }

    public function simpanTransaksi()
    {
        if ($this->tipe_transaksi == 'Halodoc') {
            $this->validate([
                'customer' => 'required',
            ], [
                'customer.required' => 'Nama Customer belum di isi',
            ]);
        }


        if ($this->tipe_bayar == 'Non Tunai') {
            $this->validate(['bayar' => 'required'], ['bayar.required' => 'Pilih Metode pembayaran']);
        }
        if ($this->kembalian < 0) {
            return $this->addError('kembalian', 'Jumlah bayar kurang');
        }


        $temps = OrderOutTemp::all();
        if (count($temps) == 0) {
            return $this->addError('kembalian', 'Keranjang masih kosong');
        }

        $trx = Transaction::create([
            'no_transaksi' => $this->no_transaksi,
            'petugas_id' => Auth::user()->id,
            'shift_id' => $this->shift,
            'tanggal' => now(),
            'jenis' => 'Non Resep',
            'tipe_transaksi' => $this->tipe_transaksi,
            'tipe_bayar' => $this->tipe_bayar,
            'bayar' => $this->bayar,
            'pasien' => $this->customer,
            'keterangan' => $this->keterangan != null ? $this->keterangan : null,
            'total' => $this->total,
            'jumlah_bayar' => $this->jumlahBayar
        ]);

        foreach ($temps as  $item) {
            $item['transaksi_id'] = $trx->id;
            OrderOut::create($item->toArray());

            $product = Product::find($item->product_id);
            $product->stok -= $item->qty;
            $product->save();
            Record::create([
                'product_id' => $item->product_id,
                'sisa_stok' => $product->stok,
                'no_transaksi' => $trx->no_transaksi,
                'record' => 'Out'
            ]);
        }

        OrderOutTemp::truncate();
        session()->flash('message', 'Transaksi berhasil di simpan.');
        return redirect()->route('non-resep');
    }

    public function resetCreateForm()
    {
        $this->reset(['product_id', 'product',  'qty', 'harga_beli', 'jenis_harga']);
    }
    public function resetError()
    {
        $this->resetErrorBag();
    }

    public function deleteCart($id)
    {
        $order = OrderOutTemp::find($id);
        $order->delete();
    }
}
