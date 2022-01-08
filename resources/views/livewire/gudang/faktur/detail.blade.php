@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
<section class="section">
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
    <div class="section-header row g-2">
        <div class="col">
            <h1>Detail Faktur</h1>
        </div>
        <div class="col-auto">

        </div>
    </div>
    <div class="section-body">
        <div class="container">
            <div class="section-title">Data Faktur Penerimaa Barang</div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Supplier</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $supplier }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Tanggal</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $faktur->created_at->format('d-m-Y') }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Nomer Faktur</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $faktur->no_faktur }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Nomer SP</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $faktur->no_sp }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Cara Bayar</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $faktur->bayar }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Jatuh Tempo</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">
                                {{ $faktur->tempo != null ? $faktur->tempo : '-' }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Keterangan</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $faktur->keterangan }}</h6>
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
                                    <th style="min-width: 180px">Nama Obat</th>
                                    <th>No Batch</th>
                                    <th>Expired</th>
                                    <th>Satuan</th>
                                    <th>Qty</th>
                                    <th>Harga Beli</th>
                                    <th>Diskon (%)</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($lists) > 0)
                                    @foreach ($lists as $item)
                                        <tr>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->batch }}</td>
                                            <td>{{ $item->expired }}</td>
                                            <td>{{ $item->product->satuan }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>@rupiah( $item->harga_beli)</td>
                                            <td>{{ $item->diskon }}%</td>
                                            <td>@rupiah($item->sub_total)</td>
                                            <td>
                                                @if ($trx_id == $item->product_id && $edit)
                                                    <div style="width: 150px">
                                                        <label for="retur" class="form-label">Masukan Jumlah
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
                                    <td colspan="7" class="text-right">
                                        Total
                                    </td>
                                    <td>
                                        @rupiah($faktur->total)
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right">
                                        <h5>Total Real</h5>
                                    </td>
                                    <td>
                                        <h5>@rupiah($faktur->total_real)</h5>
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
