<?php

namespace App\Http\Livewire\Transaksi\NonResep;

use Carbon\Carbon;
use App\Models\Shift;
use App\Models\Record;
use App\Models\Product;
use Livewire\Component;
use App\Models\OrderOut;
use App\Models\JenisHarga;
use Mike42\Escpos\Printer;
use App\Models\Transaction;
use App\Models\OrderOutTemp;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

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
        $harga = JenisHarga::whereIn('name', ['Otc', 'Ethical'])->get();
        if ($this->tipe_transaksi == 'Halodoc') {
            $harga = JenisHarga::where('name', 'Halodoc')->get();
        }

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
        if ($this->tipe_transaksi == 'Halodoc') {
            $j_harga = JenisHarga::where('name', 'Halodoc')->first();
        }
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
                'qty' => $item->qty,
                'sisa_stok' => $product->stok,
                'no_transaksi' => $trx->no_transaksi,
                'record' => 'Out',
                'keterangan' => 'Penjualan'
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

    public function print()
    {
        // Set params
        $mid = '123123456';
        $store_name = 'YOURMART';
        $store_address = 'Mart Address';
        $store_phone = '1234567890';
        $store_email = 'yourmart@email.com';
        $store_website = 'yourmart.com';
        $tax_percentage = 10;
        $transaction_id = 'TX123ABC456';
        $currency = 'Rp';

        // Set items
        $items = [
            [
                'name' => 'French Fries (tera)',
                'qty' => 2,
                'price' => 65000,
            ],
            [
                'name' => 'Roasted Milk Tea (large)',
                'qty' => 1,
                'price' => 24000,
            ],
        ];

        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

        // Set currency
        $printer->setCurrency($currency);

        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['price']
            );
        }
        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);


        // Print receipt
        $printer->printReceipt();
    }

    public function print2()
    {
        $no_trx = '123';

        $connector = new WindowsPrintConnector('POS-58');
        $profile = CapabilityProfile::load("default");
        // Connect to printer
        $printer = new Printer($connector, $profile);

        // Init printer settings
        $printer->initialize();
        $printer->selectPrintMode();

        // //header
        // $printer->setJustification(Printer::JUSTIFY_CENTER);
        // $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        // $printer->text("Apotek Ananda");
        // $printer->selectPrintMode();
        // $printer->text("Siliwangi\n");
        // $printer->text("Jl. Siliwangi  No.201 Cirebon\n");
        // $printer->feed();
        // $printer->text($this->printDashedLine());

        // $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $printer->text("No.R");
        // $printer->setJustification(Printer::JUSTIFY_RIGHT);
        // $printer->text($no_trx);
        // $printer->feed();
        // $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $printer->text("Tanggal");
        // $printer->setJustification(Printer::JUSTIFY_RIGHT);
        // $printer->text("01-02-2022");
        // $printer->feed();
        // $printer->text($this->printDashedLine());
        // $printer->feed(2);

        /* Justification */
        $justification = array(
            Printer::JUSTIFY_LEFT,
            Printer::JUSTIFY_CENTER,
            Printer::JUSTIFY_RIGHT
        );
        for ($i = 0; $i < count($justification); $i++) {
            $printer->setJustification($justification[$i]);
            $printer->text("tes");
        }
        $printer->setJustification(); // Reset
        // //item
        // $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $printer->text("Paracetamol");
        // $printer->feed();
        // $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $printer->text("Rp3.500 X 2");
        // $printer->feedReverse();
        // $printer->setJustification(Printer::JUSTIFY_RIGHT);
        // $printer->text("Rp7.000");
        // $printer->feed();
        // $printer->text($this->printDashedLine());

        // $printer->feed(2);
        // $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        // $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $printer->text("Total");
        // $printer->setJustification(Printer::JUSTIFY_RIGHT);
        // $printer->text("Rp7.000");
        // $printer->feed();
        // $printer->selectPrintMode();
        // $printer->text($this->printDashedLine());

        // //footer
        // $printer->feed(2);
        // $printer->setJustification(Printer::JUSTIFY_CENTER);
        // $printer->text("Terima Kasih");
        // $printer->feed(2);

        // Cut the receipt
        $printer->cut();
        $printer->close();
    }

    public function print3()
    {
        $connector = new WindowsPrintConnector('POS-58');
        $profile = CapabilityProfile::load("default");
        // Connect to printer
        $printer = new Printer($connector, $profile);

        $printer->initialize();

        /* Text */
        $printer->text("Hello world\n");
        $printer->cut();

        /* Line feeds */
        $printer->text("ABC");
        $printer->feed(7);
        $printer->text("DEF");
        $printer->feedReverse(3);
        $printer->text("GHI");
        $printer->feed();
        $printer->cut();

        /* Font modes */
        $modes = array(
            Printer::MODE_FONT_B,
            Printer::MODE_EMPHASIZED,
            Printer::MODE_DOUBLE_HEIGHT,
            Printer::MODE_DOUBLE_WIDTH,
            Printer::MODE_UNDERLINE
        );
        for ($i = 0; $i < pow(2, count($modes)); $i++) {
            $bits = str_pad(decbin($i), count($modes), "0", STR_PAD_LEFT);
            $mode = 0;
            for ($j = 0; $j < strlen($bits); $j++) {
                if (substr($bits, $j, 1) == "1") {
                    $mode |= $modes[$j];
                }
            }
            $printer->selectPrintMode($mode);
            $printer->text("ABCDEFGHIJabcdefghijk\n");
        }
        $printer->selectPrintMode(); // Reset
        $printer->cut();

        /* Underline */
        for ($i = 0; $i < 3; $i++) {
            $printer->setUnderline($i);
            $printer->text("The quick brown fox jumps over the lazy dog\n");
        }
        $printer->setUnderline(0); // Reset
        $printer->cut();

        /* Cuts */
        $printer->text("Partial cut\n(not available on all printers)\n");
        $printer->cut(Printer::CUT_PARTIAL);
        $printer->text("Full cut\n");
        $printer->cut(Printer::CUT_FULL);

        /* Emphasis */
        for ($i = 0; $i < 2; $i++) {
            $printer->setEmphasis($i == 1);
            $printer->text("The quick brown fox jumps over the lazy dog\n");
        }
        $printer->setEmphasis(false); // Reset
        $printer->cut();

        /* Double-strike (looks basically the same as emphasis) */
        for ($i = 0; $i < 2; $i++) {
            $printer->setDoubleStrike($i == 1);
            $printer->text("The quick brown fox jumps over the lazy dog\n");
        }
        $printer->setDoubleStrike(false);
        $printer->cut();

        /* Fonts (many printers do not have a 'Font C') */
        $fonts = array(
            Printer::FONT_A,
            Printer::FONT_B,
            Printer::FONT_C
        );
        for ($i = 0; $i < count($fonts); $i++) {
            $printer->setFont($fonts[$i]);
            $printer->text("The quick brown fox jumps over the lazy dog\n");
        }
        $printer->setFont(); // Reset
        $printer->cut();

        /* Justification */
        $justification = array(
            Printer::JUSTIFY_LEFT,
            Printer::JUSTIFY_CENTER,
            Printer::JUSTIFY_RIGHT
        );
        for ($i = 0; $i < count($justification); $i++) {
            $printer->setJustification($justification[$i]);
            $printer->text("A man a plan a canal panama\n");
        }
        $printer->setJustification(); // Reset
        $printer->cut();

        /* Barcodes - see barcode.php for more detail */
        $printer->setBarcodeHeight(80);
        $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
        $printer->barcode("9876");
        $printer->feed();
        $printer->cut();

        // /* Graphics - this demo will not work on some non-Epson printers */
        // try {
        //     $logo = EscposImage::load("resources/escpos-php.png", false);
        //     $imgModes = array(
        //         Printer::IMG_DEFAULT,
        //         Printer::IMG_DOUBLE_WIDTH,
        //         Printer::IMG_DOUBLE_HEIGHT,
        //         Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT
        //     );
        //     foreach ($imgModes as $mode) {
        //         $printer->graphics($logo, $mode);
        //     }
        // } catch (Exception $e) {
        //     /* Images not supported on your PHP, or image file not found */
        //     $printer->text($e->getMessage() . "\n");
        // }
        // $printer->cut();

        // /* Bit image */
        // try {
        //     $logo = EscposImage::load("resources/escpos-php.png", false);
        //     $imgModes = array(
        //         Printer::IMG_DEFAULT,
        //         Printer::IMG_DOUBLE_WIDTH,
        //         Printer::IMG_DOUBLE_HEIGHT,
        //         Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT
        //     );
        //     foreach ($imgModes as $mode) {
        //         $printer->bitImage($logo, $mode);
        //     }
        // } catch (Exception $e) {
        //     /* Images not supported on your PHP, or image file not found */
        //     $printer->text($e->getMessage() . "\n");
        // }
        $printer->cut();

        /* QR Code - see also the more in-depth demo at qr-code.php */
        $testStr = "Testing 123";
        $models = array(
            Printer::QR_MODEL_1 => "QR Model 1",
            Printer::QR_MODEL_2 => "QR Model 2 (default)",
            Printer::QR_MICRO => "Micro QR code\n(not supported on all printers)"
        );
        foreach ($models as $model => $name) {
            $printer->qrCode($testStr, Printer::QR_ECLEVEL_L, 3, $model);
            $printer->text("$name\n");
            $printer->feed();
        }
        $printer->cut();

        /* Pulse */
        $printer->pulse();

        /* Always close the printer! On some PrintConnectors, no actual
 * data is sent until the printer is closed. */
        $printer->close();
    }

    public function printDashedLine()
    {
        $line = '';

        for ($i = 0; $i < 32; $i++) {
            $line .= '-';
        }

        return $line;
    }
}
