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

        .modal .modal-body {
            max-height: 420px;
            overflow-y: auto;
        }

    </style>
@endpush
<section class="section">
    <div wire:ignore>
        <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <livewire:transaksi.resep.form-racikan>
        </div>
    </div>
    <div class="section-header row">
        <div class="col">
            <h5>Transaksi Penjualan Resep</h5>
        </div>
        <div class="col-auto">
            {{-- wire:click="print2" --}}
            <button wire:click="openFormRacik" class="btn btn-sm btn-secondary text-dark"><i
                    class="fas fa-mortar-pestle"></i>
                Buat Racikan</button>
        </div>
        <div class="col-auto">
            {{-- wire:click="print2" --}}
            <button onclick="alert('Coming Soon');" class="btn btn-sm btn-primary"><i class="fas fa-print"></i>
                Print</button>
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
                                    <label for="dokter" class="col-sm-1 mr-5 col-form-label text-nowrap">Dokter</label>
                                    <div class="col-sm">
                                        <select wire:model.lazy="dokter"
                                            class="custom-select custom-select-sm mr-sm-1 mr-3 @error('dokter') is-invalid @else '' @enderror"
                                            id="dokter">
                                            <option selected>Pilih...</option>
                                            @foreach ($dokters as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('dokter')
                                            <script>
                                                show('{{ $message }}')
                                            </script>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_resep"
                                        class="col-sm-1 mr-5 col-form-label col-form-label-sm text-nowrap">No
                                        Resep</label>
                                    <div class="col-sm">
                                        <input wire:model="no_resep" autocomplete="off" type="text"
                                            class="form-control form-control-sm @error('no_resep') is-invalid @enderror"
                                            id="no_resep">
                                        @error('no_resep')
                                            <script>
                                                show('{{ $message }}')
                                            </script>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pasien"
                                        class="col-sm-1 mr-5 col-form-label col-form-label-sm text-nowrap">Pasien</label>
                                    <div class="col-sm">
                                        <input wire:model="pasien" autocomplete="off" type="text"
                                            class="form-control form-control-sm " id="pasien">
                                        @error('pasien')
                                            <script>
                                                show('{{ $message }}')
                                            </script>
                                        @enderror
                                    </div>
                                </div>
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
                                    <div class="col-6 mb-3">
                                        <div class="input-group mt-2">
                                            <select wire:model.defer="racikan_id"
                                                class="custom-select custom-select-sm @error('racikan_id') is-invalid @enderror"
                                                id="racikan" aria-label="Racikan">
                                                <option selected value="">Pilih Racikan...</option>
                                                @foreach ($racikans as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->nama_racikan }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <input wire:model.defer='qty_r' style="width: 80px" type="number"
                                                    class="form-control @error('qty_r') is-invalid @enderror"
                                                    placeholder="Qty">
                                            </div>
                                            <div class="input-group-append">
                                                <button wire:click="addRacikan" class="btn btn-sm btn-primary"
                                                    type="button"><i class="fas fa-plus px-2"></i></button>
                                            </div>
                                        </div>
                                        @error('racikan_id')
                                            <script>
                                                show('{{ $message }}');
                                            </script>
                                        @enderror
                                        @error('qty_r')
                                            <script>
                                                show('{{ $message }}');
                                            </script>
                                        @enderror
                                    </div>
                                    <div class="col-6  mb-3">
                                        <div class="input-group mt-2">
                                            <select wire:model="pelayanan_id"
                                                class="custom-select custom-select-sm @error('pelayanan_id') is-invalid @enderror"
                                                id="pelayanan_id" aria-label="Pelayanan">
                                                <option selected value="">Pilih Pelayanan...</option>
                                                @foreach ($pelayanan as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <input wire:model.defer='qty_p' style="width: 60px" type="number"
                                                    class="form-control @error('qty_p') is-invalid @enderror"
                                                    placeholder="Qty">
                                            </div>
                                            <div class="input-group-append">
                                                <button wire:click="addPelayanan" class="btn btn-sm btn-primary"
                                                    type="button"><i class="fas fa-plus px-2"></i></button>
                                            </div>
                                        </div>
                                        @error('qty_p')
                                            <script>
                                                show('{{ $message }}');
                                            </script>
                                        @enderror
                                    </div>
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
                        <div style="height: 350px" class=" table-responsive">
                            <table class="table table-hover table-md text-nowrap table-sm align-middle p-2">
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
