@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
<section class="section">
    <div class="section-header row g-2">
        <div class="col">
            <h1>Detail Transaksi</h1>
        </div>
        <div class="col-auto">

        </div>
    </div>
    @error('stok')
        <script>
            show('{{ $message }}')
        </script>
    @enderror
    @if (session()->has('message'))
        <script>
            success('{{ session('message') }}')
        </script>
    @endif
    <div class="section-body">
        <div class="container">
            <div class="section-title">Data Transaksi</div>
            <div class="row">
                <div class="col-7">
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Tanggal</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">: {{ $transaksi->created_at->format('d-m-Y') }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Nomer Transaksi</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">: {{ $transaksi->no_transaksi }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Tipe Transaksi</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">: {{ $transaksi->tipe_transaksi }}</h6>
                        </div>
                    </div>
                    @if ($transaksi->tipe_transaksi == 'Halodoc')
                        <div class="row">
                            <div class="col-sm-3 ">
                                <h6>Customer</h6>
                            </div>
                            <div class="col-sm ">
                                <h6 class="text-left">: {{ $transaksi->pasien }}</h6>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Cara Bayar</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">: {{ $transaksi->tipe_bayar }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Bayar Via</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">: {{ $transaksi->bayar != null ? $transaksi->bayar : '-' }}
                            </h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Keterangan</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">: {{ $transaksi->keterangan }}</h6>
                        </div>
                    </div>
                </div>


                <div class="col-6"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title">Data Barang</div>
                    <div class="table-responsive">
                        <table class="table table-hover table-md text-nowrap text-dark table-bordered table-primary">
                            <thead>
                                <tr>
                                    <th style="min-width: 50px">No</th>
                                    <th style="min-width: 250px">Nama Obat</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Jenis Harga</th>
                                    <th>SubTotal</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($list) > 0)
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>@rupiah( $item->harga_jual)</td>
                                            <td>{{ $item->jenisHarga->name }}</td>
                                            <td>@rupiah($item->sub_total)</td>
                                            <td class="text-center" style="width: 100px">
                                                @if ($trx_id == $item->product_id && $edit)
                                                    <div style="width: 100px">
                                                        <label for="retur" class="form-label">Jumlah
                                                            Retur</label>
                                                        <input id="retur" wire:model.prevent='retur'
                                                            class="form-control form-control-sm" type="number" min="0">
                                                        <div class="row">
                                                            <div class="col">
                                                                <button
                                                                    class="mt-2 btn btn-sm btn-danger btn-block form-control form-control-sm"
                                                                    wire:click='resetInput'>Batal</button>
                                                            </div>
                                                            <div class="col"><button wire:click='update'
                                                                    class="mt-2 btn btn-sm btn-primary btn-block form-control form-control-sm">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <button wire:click.prevent='edit({{ $item->product_id }})'
                                                        class="btn btn-sm btn-danger">Retur</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="10" class="text-center">Item masih kosong</td>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right">
                                        <h5>Total</h5>
                                    </td>
                                    <td>
                                        <h5 class="text-center">@rupiah($transaksi->total)</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('toast')
    <!-- Page Specific JS File -->
    <script src="{{ asset('node_modules/izitoast/dist/js/iziToast.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('assets/js/page/modules-toastr.js') }}"></script>

    <script>
        function show(error) {
            iziToast.warning({
                message: error,
                position: "topRight",
            });
            setInterval(() => {
                Livewire.emit('resetError');
            }, 2000);
        }

        function success(message) {
            iziToast.success({
                message: message,
                position: "topRight",
            });
        }
    </script>

@endpush
