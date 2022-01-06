<?php

namespace App\Http\Livewire\Transaksi\NonResep;

use App\Models\JenisHarga;
use Carbon\Carbon;
use App\Models\Shift;
use Livewire\Component;
use App\Models\OrderOut;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ListTransaksi extends Component
{
    public $transaksi, $start_, $end_;
    public $start, $end, $cari, $total;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $transaksis = null;
        $transaksi = DB::table('order_outs')
            ->join('transactions', 'transaksi_id', '=', 'transactions.id')
            ->select('order_outs.*', 'transactions.tipe_transaksi', 'transactions.created_at');
        if ($this->cari != null) {
            // $transaksis = OrderOut::where('tipe_transaksi', 'like', '%' . $this->cari . '%')->paginate(15);
            $transaksis = $transaksi->where('jenis', 'Non Resep')->where('tipe_transaksi', $this->cari)
                ->whereBetween('transactions.created_at', array($this->start, $this->end))->orderBy('transactions.created_at', 'DESC')
                ->get();
        } else {
            $transaksis = $transaksi->where('jenis', 'Non Resep')->whereBetween('transactions.created_at', array($this->start, $this->end))->orderBy('transactions.created_at', 'DESC')->get();
        }

        $this->total = $transaksis->sum('sub_total');
        return view('livewire.transaksi.non-resep.list-transaksi')->with(compact('transaksis'));
    }

    public function mount()
    {
        $shift = $this->cekShift();

        switch ($shift->id) {
            case 1:
                $this->start = now()->createFromTime(07, 00, 00);
                $this->end = now()->createFromTime(14, 00, 00);
                break;
            case 2:
                $this->start = now()->createFromTime(14, 00, 00);
                $this->end = now()->createFromTime(21, 00, 00);
                break;
            case 3:
                if (now()->format('A') == 'PM') {
                    $this->start = now()->createFromTime(21, 00, 00);
                    $this->end = now()->createFromTime(07, 00, 00)->addDay(1);
                } else {
                    $this->start = now()->createFromTime(21, 00, 00)->addDay(-1);
                    $this->end = now()->createFromTime(07, 00, 00);
                }
                break;

            default:
                $this->start = now()->createFromTime(07, 00, 00);
                $this->end = now()->createFromTime(14, 00, 00);
                break;
        }

        $this->start_ = $this->start->format('d-m-Y H:i');
        $this->end_ = $this->end->format('d-m-Y H:i');


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
                $start = Carbon::createFromFormat('h:i A', '09:00 PM');

                if ($now->format('A') == 'PM') {
                    $end->addDay(1);
                } else {
                    $start->addDay(-1);
                }
            }


            if ($now->isBetween($start, $end)) {
                return $item;
            }
        }
    }

    public function getJenisHarga($id)
    {
        return JenisHarga::find($id)->name;
    }
}
