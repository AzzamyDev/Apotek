@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
    <style>
        .btn-primary,
        .btn-primary:hover,
        .btn-primary:active,
        .btn-primary:visited {
            background-color: #5cb85c !important;
            border-color: #5cb85c !important;
        }

    </style>
@endpush
<section class="section">

    <div class="section-header row">
        <div class="col">
            <h5>Transaksi Penjualan Non Resep</h5>
        </div>
        <div class="col-auto">
            <h5>Shift : {{ $shift }}</h5>
        </div>
        <div class="col-auto">
            <h6><span><i class="fas fa-user"></i></span> Petugas : {{ Auth::user()->name }}</h6>
        </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-3">
                        <div class="card sticky-top">
                            <div class="card-body">
                                <h5>#{{ $no_transaksi }}</h5>
                                <div class="form-group row">
                                    <label for="tanggal"
                                        class="col-sm-1 mr-5 col-form-label col-form-label-sm text-nowrap">Tanggal</label>
                                    <div class="col-sm">
                                        {{ now()->format('d F Y') }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tipe_bayar"
                                        class="col-sm-12 col-form-label col-form-label-sm text-nowrap">Tipe
                                        Transaksi</label>
                                    <div class="col-sm">
                                        <div wire:loading.remove wire:target='tipe_transaksi' class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input wire:model="tipe_transaksi" type="radio" name="tipe_transaksi"
                                                    value="Umum" class="selectgroup-input selectgroup-input-sm"
                                                    checked="">
                                                <span class="selectgroup-button selectgroup-button-icon"><i
                                                        class="fas fa-shopping-cart"></i></span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input wire:model="tipe_transaksi" type="radio" name="tipe_transaksi"
                                                    value="Halodoc" class="selectgroup-input selectgroup-input-sm">
                                                <span class="selectgroup-button selectgroup-button-icon"><i
                                                        class="fas fa-stethoscope"></i></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div wire:loading wire:loading.delay.longest wire:target='tipe_transaksi'
                                    class="badge badge-primary mb-2">
                                    <i class="fas fa-cog"></i> Mengubah Transaksi...
                                </div>
                                @if ($tipe_transaksi == 'Halodoc')
                                    <div class="form-group row">
                                        <label for="customer"
                                            class="col-sm-1 mr-5 col-form-label col-form-label-sm text-nowrap">Customer</label>
                                        <div class="col-sm">
                                            <input wire:model.defer="customer" autocomplete="off" type="text"
                                                class="form-control form-control-sm @error('customer') is-invalid @enderror"
                                                id="customer">
                                            @error('customer')
                                                <script>
                                                    show('{{ $message }}')
                                                </script>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row">
                                    <label for="keterangan"
                                        class="col-sm-1 mr-5 col-form-label col-form-label-sm text-nowrap">Keterangan</label>
                                    <div class="col-sm">
                                        <input wire:model.defer="keterangan" autocomplete="off" type="text"
                                            class="form-control form-control-sm " id="keterangan">
                                        @error('keterangan')
                                            <script>
                                                show('{{ $message }}')
                                            </script>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tipe_bayar"
                                        class="col-sm-12 col-form-label col-form-label-sm text-nowrap">Tipe
                                        Bayar</label>
                                    <div class="col-sm">
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input wire:model="tipe_bayar" type="radio" name="tipe_bayar"
                                                    value="Tunai" class="selectgroup-input selectgroup-input-sm"
                                                    checked="">
                                                <span class="selectgroup-button">Tunai</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input wire:model="tipe_bayar" type="radio" name="tipe_bayar"
                                                    value="Non Tunai" class="selectgroup-input selectgroup-input-sm">
                                                <span class="selectgroup-button">Non Tunai</span>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($tipe_bayar == 'Non Tunai')
                                        <div class="col-12">
                                            <select wire:model.lazy="bayar"
                                                class="custom-select custom-select-sm @error('bayar') bg-danger @enderror"
                                                name="bayar" id="bayar">
                                                <option selected>Pilih Pembayaran</option>
                                                <option value="Debit">Debit</option>
                                                <option value="Gopay">Gopay</option>
                                                <option value="Ovo">Ovo</option>
                                                <option value="Dana">Dana</option>
                                                <option value="LinkAja">LinkAja</option>
                                                <option value="Qris">Qris</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                            @error('bayar')
                                                <script>
                                                    show('{{ $message }}');
                                                </script>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                                <div class="section-title">Total</div>
                                <div class=" row">
                                    <div class="col-sm-12">
                                        <h5 class="text-right">@rupiah($total)</h5>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="biaya_lain"
                                        class="col-sm-auto col-form-label col-form-label text-nowrap">
                                        Jumlah Bayar
                                    </label>
                                    <div class="col-sm">
                                        <input wire:model="jumlahBayar" autocomplete="off" type="number"
                                            class="form-control form-control-sm text-right currency" id="jumlah_bayar">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kembalian"
                                        class="col-sm-auto col-form-label col-form-label text-nowrap">
                                        Kembalian
                                    </label>
                                    <div class="col-sm">
                                        <h5 class="text-right">@rupiah($kembalian)</h5>
                                    </div>
                                </div>
                                @error('kembalian')
                                    <script>
                                        show('{{ $message }}');
                                    </script>
                                @enderror
                                <button wire:loading.attr="disabled" type="button" wire:click="simpanTransaksi"
                                    class="mt-3 btn btn-block btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">
                                <h5>Tambah Item</h5>
                                <div class="form-row align-items-center">
                                    <div class="col-md">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i
                                                        class="fas fa-{{ $product != null ? 'pills' : 'search' }}"></i>
                                                </div>
                                            </div>
                                            <input wire:model='cari' autocomplete="off" type="text" list="data_obat"
                                                class="form-control @if ($product != null)is-valid @else 'is-invalid' @endif" id="cari"
                                                placeholder="Cari Obat">
                                            <div style="max-height: 100px; overflow-y: auto">
                                                <datalist id="data_obat">
                                                    @foreach ($products as $item)
                                                        <option value="{{ $item->name }}">Sisa stok :
                                                            {{ $item->stok }}
                                                            @foreach ($harga as $i)
                                                                | {{ $i->name }} :
                                                                @rupiah((1.1 * $item->harga)*(1+($i->persentase/100)))
                                                            @endforeach
                                                        </option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                            @error('cari')
                                                <script>
                                                    show('{{ $message }}')
                                                </script>
                                            @enderror
                                            @error('product_id')
                                                <script>
                                                    show('{{ $message }}')
                                                </script>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend ">
                                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                            </div>
                                            <input disabled wire:model.defer="harga_beli" autocomplete="off"
                                                type="number" aria-describedby="helper"
                                                class="form-control @error('harga_beli') is-invalid @else '' @enderror"
                                                id="harga_beli" placeholder="Rp.0">
                                            @error('harga_beli')
                                                <script>
                                                    show('{{ $message }}')
                                                </script>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-cart-plus"></i></div>
                                            </div>
                                            <input wire:model.defer="qty" autocomplete="off" type="number"
                                                class="form-control @error('qty') is-invalid @else '' @enderror"
                                                id="qty" placeholder="Qty">
                                            @error('qty')
                                                <script>
                                                    show('{{ $message }}')
                                                </script>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <div class="input-group ">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-money-bill"></i></div>
                                            </div>
                                            <select wire:model="jenis_harga" class="custom-select custom-select-sm"
                                                name="jenis_harga" id="jenis_harga">
                                                <option selected value="">Pilih..</option>
                                                @foreach ($jenisHarga as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('jenis_harga')
                                                <script>
                                                    show('{{ $message }}')
                                                </script>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-auto">
                                        <div class="input-group">
                                            <button {{ $product != null ? '' : 'disable' }} type="button"
                                                wire:click="addBarang()" class="btn btn-primary btn-block"><span><i
                                                        class="fas fa-plus"></i></span> Tambahkan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="height: 500px;max-height: 500px" class="table-responsive">
                            <table class="table table-hover table-md text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="min-width: 50px">No</th>
                                        <th style="min-width: 200px">Nama Obat</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Jenis Harga</th>
                                        <th>SubTotal</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($temps) > 0)
                                        @foreach ($temps as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $item->nama_barang }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>@rupiah( $item->harga_jual)</td>
                                                <td>{{ $item->jenisHarga->name }}</td>
                                                <td>@rupiah($item->sub_total)</td>
                                                <td class="text-center">
                                                    <i style="cursor: pointer"
                                                        wire:click='deleteCart({{ $item->id }})'
                                                        class="fas fa-trash"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr style="height: 180px">
                                            <td colspan="10" class="text-center pt-4">
                                                <img src="{{ asset('assets/img/empty-cart.svg') }}" alt=""
                                                    style="max-height: 180px">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="10" class="text-center"><small>Keranjang Masih
                                                    kosong</small></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-footer d-flex justify-content-center mt-3">
        {{-- {{ $products->links() }} --}}

    </div>
</section>

@push('toast')
    <!-- Page Specific JS File -->
    <script src="{{ asset('node_modules/izitoast/dist/js/iziToast.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('assets/js/page/modules-toastr.js') }}"></script>
    <script>
        window.livewire.on('toggleFormModal', () => {
            $('#form-modal').appendTo('body');
            $('#form-modal').modal('toggle');
        });
        window.addEventListener('focus', event => {
            $('#cari').focus();
        });
        window.addEventListener('log', event => {
            console.log(event.detail.q);
            $('#data_obat').append(event.detail.q);
        });
    </script>
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
    <script>
        $(document).ready(function() {
            $('#cari').focus();
        })
        document.addEventListener("keydown", function(event) {
            if (event.keyCode == 115) {
                $('#jumlah_bayar').focus();
            }
            if (event.keyCode == 113) {
                $('#cari').focus();
            }
        });
    </script>
    @if (session()->has('message'))
        <script>
            success('{{ session('message') }}')
        </script>
    @endif
@endpush

@push('js_lib')

    <!-- JS Libraies -->
    <script src="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('node_modules/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
@push('custom_js')
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script>
@endpush
