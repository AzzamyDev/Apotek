<?php

namespace App\Http\Livewire\Transaksi\Resep;

use App\Models\Dokter;
use App\Models\ItemRacikan;
use App\Models\ItemRacikanTemp;
use Carbon\Carbon;
use App\Models\Shift;
use App\Models\Record;
use App\Models\Product;
use Livewire\Component;
use App\Models\OrderOut;
use App\Models\JenisHarga;
use App\Models\Transaction;
use App\Models\OrderOutTemp;
use App\Models\Racikan;
use App\Models\RacikanTemp;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $total, $product, $product_id, $stok, $cari, $harga_beli, $qty, $keterangan, $tanggal;
    public $jumlahBayar, $tipe_bayar, $bayar, $shift, $no_transaksi, $jenis_harga,
        $tipe_transaksi, $dokter, $no_resep, $racikan, $pasien,
        $pelayanan_id, $qty_p, $racikan_id, $qty_r;
    public $kembalian = 0;
    protected $listeners = ['resetError', 'fresh' => '$refresh'];

    public function render()
    {
        if ($this->product == null) {
            $products = [];
            if (strlen($this->cari) >= 3) {
                $products = Product::where('name', 'like', '%' . $this->cari . '%')
                    ->where('status', 1)->take(10)->get();
            }
        } else {
            $products = [];
        }

        $dokters = Dokter::all();
        $temps = OrderOutTemp::all();
        $this->total = OrderOutTemp::all()->sum('sub_total');
        $harga = JenisHarga::where('name', 'Resep')->get();
        $racikans = RacikanTemp::all();
        $pelayanan = Product::where('tipe_barang_id', 6)->get();
        return view('livewire.transaksi.resep.form')->with(compact(['products', 'temps', 'harga', 'pelayanan', 'dokters', 'racikans']));
    }

    public function openFormRacik()
    {
        if ($this->no_resep == null) {
            return $this->addError('no_resep', 'Nomer Resep belum di set');
        }
        $this->emitTo('transaksi.resep.form-racikan', 'open', $this->no_resep);
    }

    public function pembulatan($t)
    {
        if (strlen($t) > 3) {
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
        } else {
            $nominal = substr($t, -2);
            $t -= $nominal;
            if ($nominal > 75) {
                return $t += 100;
            }
            if ($nominal > 25 && $nominal < 75) {
                return $t += 50;
            }
            if ($nominal < 25 && $nominal > 0) {
                return $t += 0;
            }
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
                $start = Carbon::createFromFormat('h:i A', '09:00 PM');

                if ($now->format('A') == 'PM') {
                    $end->addDay(1);
                } else {
                    $start->addDay(-1);
                }
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
    // public function updatedTipeTransaksi($val)
    // {
    //     if ($val != 'Halodoc') {
    //         $this->customer = null;
    //     }
    // }

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


        $j_harga = JenisHarga::where('name', 'Resep')->first();
        $hna = $this->product->harga;
        $hna_ppn = $hna * 1.1;
        $H = $hna_ppn * (1 + ($j_harga->persentase / 100));

        $harga_final = $this->pembulatan(ceil($H));

        OrderOutTemp::create([
            'jenis_order' => 'product',
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

    public function addRacikan()
    {
        if ($this->racikan_id == null) {
            return $this->addError('racikan_id', 'Set racikan dulu');
        }
        $racikan = RacikanTemp::find($this->racikan_id);
        $this->validate([
            'qty_r' => 'required',
        ], [
            'qty_r.required' => 'Qty belum di isi',
        ]);
        OrderOutTemp::create([
            'jenis_order' => 'racikan',
            'racikan_id' => $racikan->id,
            'nama_barang' => $racikan->nama_racikan,
            'qty' => $this->qty_r,
            'jenis_harga_id' => JenisHarga::where('name', 'Resep')->first()->id,
            'harga_beli' => $racikan->total,
            'harga_jual' => $racikan->total,
            'sub_total' => $this->qty_r * $racikan->total,
        ]);

        $this->reset(['racikan_id', 'qty_r']);
        $this->dispatchBrowserEvent('focus');
    }

    public function addPelayanan()
    {
        if ($this->pelayanan_id == null) {
            return $this->addError('pelayanan_id', 'Set pelayanan dulu');
        }

        $product = Product::find($this->pelayanan_id);
        if (OrderOutTemp::where('product_id', $product->id)->exists()) {
            return $this->addError('pelayanan_id', 'Product sudah ada');
        }

        $this->validate([
            'qty_p' => 'required',
        ], [
            'qty_p.required' => 'Qty belum di isi',
        ]);
        OrderOutTemp::create([
            'jenis_order' => 'pelayanan',
            'product_id' => $product->id,
            'nama_barang' => $product->name,
            'qty' => $this->qty_p,
            'jenis_harga_id' => $product->tipe_harga_id,
            'harga_beli' => $product->harga,
            'harga_jual' => $product->harga,
            'sub_total' => $this->qty_p * $product->harga,
        ]);

        $this->reset(['pelayanan_id', 'qty_p']);
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
            'jenis' => 'Resep',
            'tipe_transaksi' => $this->tipe_transaksi,
            'tipe_bayar' => $this->tipe_bayar,
            'bayar' => $this->bayar,
            'no_resep' => $this->no_resep,
            'pasien' => $this->pasien,
            'dokter' => $this->dokter,
            'keterangan' => $this->keterangan != null ? $this->keterangan : null,
            'total' => $this->total,
            'jumlah_bayar' => $this->jumlahBayar
        ]);

        foreach ($temps as  $item) {
            $racikan = null;
            $item['transaksi_id'] = $trx->id;

            if ($item->jenis_order != 'racikan') {
                $product = Product::find($item->product_id);
                if ($product->tipe_barang_id != 6) {
                    $product->stok -= $item->qty;
                    $product->save();
                    Record::create([
                        'product_id' => $item->product_id,
                        'qty' => $item->qty,
                        'sisa_stok' => $product->stok,
                        'no_transaksi' => $trx->no_transaksi,
                        'record' => 'Out',
                        'keterangan' => 'Penjualan'
                    ]);
                }
            } else {
                $racikanTemp = RacikanTemp::find($item->racikan_id);
                $racikanTemp['no_resep'] = $this->no_resep;
                $racikan = Racikan::create($racikanTemp->toArray());
                foreach ($racikanTemp->item as $val) {
                    $itemRacikan = ItemRacikan::find($val->id);
                    $itemRacikan->racikan_id = $racikan->id;
                    $itemRacikan->save();

                    $product = Product::find($val->product_id);
                    $product->stok -= $val->qty;
                    $product->save();
                    Record::create([
                        'product_id' => $val->product_id,
                        'qty' => $val->qty,
                        'sisa_stok' => $product->stok,
                        'no_transaksi' => $trx->no_transaksi,
                        'record' => 'Out',
                        'keterangan' => 'Penjualan'
                    ]);
                }
                $item['racikan_id'] = $racikan->id;
            }
            OrderOut::create($item->toArray());
        }

        OrderOutTemp::truncate();
        ItemRacikanTemp::truncate();
        RacikanTemp::truncate();
        session()->flash('message', 'Transaksi berhasil di simpan.');
        return redirect()->route('resep');
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
