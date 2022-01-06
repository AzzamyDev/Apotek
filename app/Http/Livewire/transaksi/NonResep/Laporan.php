<?php

namespace App\Http\Livewire\Transaksi\NonResep;

use Carbon\Carbon;
use App\Models\Shift;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class Laporan extends Component
{
    public $transaksi;
    public $start, $end, $cari, $total;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $transaksis = null;
        if ($this->cari != null) {
            $transaksis = Transaction::where('jenis', 'Non Resep')
                ->where('no_transaksi', 'like', '%' . $this->cari . '%')
                ->orWhere('pasien', 'like', '%' . $this->cari . '%')->paginate(15);
        } else {
            $transaksis = Transaction::where('jenis', 'Non Resep')->whereBetween('created_at', array($this->start, $this->end))->orderBy('created_at', 'DESC')->paginate(15);
        }
        $this->total = $transaksis->sum('total');
        return view('livewire.transaksi.non-resep.laporan')->with(compact('transaksis'));
    }

    public function mount()
    {
        // $shift = $this->cekShift();
        // switch ($shift->id) {
        //     case 1:
        //         $this->start = now()->createFromTime(07, 00, 00);
        //         $this->end = now()->createFromTime(14, 00, 00);
        //         break;
        //     case 2:
        //         $this->start = now()->createFromTime(14, 00, 00);
        //         $this->end = now()->createFromTime(21, 00, 00);
        //         break;
        //     case 3:
        //         $this->start = now()->createFromTime(21, 00, 00)->addDay(-1);
        //         $this->end = now()->createFromTime(07, 00, 00);
        //         break;

        //     default:
        //         $this->start = now()->createFromTime(07, 00, 00);
        //         $this->end = now()->createFromTime(14, 00, 00);
        //         break;
        // }
        $this->start = now()->createFromTime(00, 00, 01);
        $this->end = now()->createFromTime(23, 59, 59);

        $this->reset('cari');
    }

    public function cekShift()
    {
        $now = Carbon::now();
        $shifts = Shift::all();
        foreach ($shifts as $item) {
            $start = Carbon::createFromFormat('h:i A', $item->start);
            $end =  Carbon::createFromFormat('h:i A', $item->end);
            if ($item->end == '07:00 AM') {
                $start = Carbon::createFromFormat('h:i A', '00:00 AM');
            }
            if ($now->isBetween($start, $end)) {
                return $item;
            }
        }
    }
}
