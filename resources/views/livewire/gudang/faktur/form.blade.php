@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
<section class="section">
    <div class="section-header row">
        <div class="col">
            <h5>Input Faktur Barang</h5>
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
                                <h5>Data Faktur</h5>
                                <div class="form-group row">
                                    <label for="tanggal"
                                        class="col-sm-1 mr-5 col-form-label col-form-label-sm text-nowrap">Tanggal</label>
                                    <div class="col-sm">
                                        <input wire:model.lazy='tanggal' autocomplete="off" type="date"
                                            class="form-control form-control-sm @error('tanggal') is-invalid @else '' @enderror"
                                            id="tanggal">
                                        @error('tanggal')
                                            <script>
                                                show('{{ $message }}')
                                            </script>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="supplier"
                                        class="col-sm-1 mr-5 col-form-label text-nowrap">Supplier</label>
                                    <div class="col-sm">
                                        <select wire:model.lazy="supplier"
                                            class="custom-select custom-select-sm mr-sm-1 mr-3 @error('supplier') is-invalid @else '' @enderror"
                                            id="supplier">
                                            <option selected>Pilih...</option>
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier')
                                            <script>
                                                show('{{ $message }}')
                                            </script>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_faktur"
                                        class="col-sm-1 mr-5 col-form-label col-form-label-sm text-nowrap">No
                                        Faktur</label>
                                    <div class="col-sm">
                                        <input wire:model.lazy="no_faktur" autocomplete="off" type="text"
                                            class="form-control form-control-sm @error('no_faktur') is-invalid @else '' @enderror"
                                            id="no_faktur">
                                        @error('no_faktur')
                                            <script>
                                                show('{{ $message }}')
                                            </script>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_sp"
                                        class="col-sm-1 mr-5 col-form-label col-form-label-sm text-nowrap">No
                                        SP</label>
                                    <div class="col-sm">
                                        <input wire:model.lazy="no_sp" autocomplete="off" type="text"
                                            class="form-control form-control-sm @error('no_sp') is-invalid @else '' @enderror"
                                            id="no_sp">
                                        @error('no_sp')
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
                                        <input wire:model.lazy="keterangan" autocomplete="off" type="text"
                                            class="form-control form-control-sm " id="keterangan">
                                        @error('keterangan')
                                            <script>
                                                show('{{ $message }}')
                                            </script>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bayar"
                                        class="col-sm-1 mr-5 col-form-label col-form-label-sm text-nowrap">Bayar</label>
                                    <div class="col-sm">
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input wire:model.defer="bayar" type="radio" name="bayar" value="Tunai"
                                                    class="selectgroup-input selectgroup-input-sm" checked="">
                                                <span class="selectgroup-button">Tunai</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input wire:model.defer="bayar" type="radio" name="bayar" value="Kredit"
                                                    class="selectgroup-input selectgroup-input-sm">
                                                <span class="selectgroup-button">Kredit</span>
                                            </label>
                                            @error('bayar')
                                                <script>
                                                    show('{{ $message }}');
                                                </script>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tempo"
                                        class="col-sm-12 col-form-label col-form-label-sm text-nowrap">Jatuh
                                        Tempo</label>
                                    <div class="col-sm">
                                        <input wire:model.defer="tempo" autocomplete="off" type="date"
                                            class="form-control form-control-sm @error('tempo') is-invalid @else '' @enderror"
                                            id="tempo">
                                        @error('tempo')
                                            <script>
                                                show('{{ $message }}')
                                            </script>
                                        @enderror
                                    </div>
                                </div>
                                <div class="section-title">Rincian</div>
                                <div class="form-group row">
                                    <label for="biaya_lain"
                                        class="col-sm-auto col-form-label col-form-label text-nowrap">
                                        Biaya Lain
                                    </label>
                                    <div class="col-sm">
                                        <input wire:model.debounce.0ms="biaya_lain" autocomplete="off" type="number"
                                            class="form-control form-control-sm text-right currency" id="biaya_lain">
                                    </div>
                                </div>
                                <hr>
                                <div class=" row">
                                    <div class="col-sm-auto ">
                                        <h6>Total</h6>
                                    </div>
                                    <div class="col-sm ">
                                        <h6 class="text-right">@rupiah($total)</h6>
                                    </div>
                                </div>
                                <div class=" row">
                                    <div class="col-sm-auto ">
                                        <h6>Diskon Apotek</h6>
                                    </div>
                                    <div class="col-sm ">
                                        <h6 class="text-right">@rupiah($total - $total_real)</h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-auto ">
                                        <h6>Total Real</h6>
                                    </div>
                                    <div class="col-sm ">
                                        <h6 class="text-right">@rupiah($total_real)</h6>
                                    </div>
                                </div>
                                <div class=" row">
                                    <div class="col-sm-auto ">
                                        <h6>PPN</h6>
                                    </div>
                                    <div class="col-sm ">
                                        <h6 class="text-right">@rupiah($ppn = $total_real * 0.1)</h6>
                                    </div>
                                </div>
                                <div class="section-title">Grand Total</div>
                                <div class=" row">
                                    <div class="col-sm-12">
                                        <h5 class="text-right">@rupiah($total +( $biaya_lain !=null ?$biaya_lain :
                                            0)
                                            + $ppn )</h5>
                                    </div>
                                </div>
                                <button type="button" wire:click="simpanTransaksi"
                                    class="mt-3 btn btn-block btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">
                                <h5>Tambah Item</h5>
                                <div class="form-row align-items-center">
                                    <div class="col-sm-6">
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
                                                            |
                                                            Harga
                                                            Beli
                                                            : @rupiah($item->harga)
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
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-qrcode"></i></div>
                                            </div>
                                            <input wire:model.defer="batch" autocomplete="off" type="text"
                                                class="form-control @error('batch') is-invalid @else '' @enderror"
                                                id="batch" placeholder="Nomer Batch">
                                            @error('batch')
                                                <script>
                                                    show('{{ $message }}')
                                                </script>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                            </div>
                                            <input wire:model.defer="expired" autocomplete="off" type="date"
                                                class="form-control @error('expired') is-invalid @else '' @enderror"
                                                id="expired" placeholder="Expired">
                                            @error('expired')
                                                <script>
                                                    show('{{ $message }}')
                                                </script>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                            </div>
                                            <input wire:model.defer="harga_beli" autocomplete="off" type="number"
                                                class="form-control @error('harga_beli') is-invalid @else '' @enderror"
                                                id="harga_beli" placeholder="Harga Beli">
                                            @error('harga_beli')
                                                <script>
                                                    show('{{ $message }}')
                                                </script>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-percent"></i></div>
                                            </div>
                                            <input wire:model.defer="diskon" autocomplete="off" type="number"
                                                class="form-control" id="diskon" placeholder="Diskon">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mt-2">
                                        <div class="input-group">
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
                                    <div class="col-sm-3 mt-2">
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
                                        <th style="min-width: 180px">Nama Obat</th>
                                        <th>No Batch</th>
                                        <th>Expired</th>
                                        <th>Satuan</th>
                                        <th>Qty</th>
                                        <th>Harga Beli</th>
                                        <th>Diskon (%)</th>
                                        <th>Total</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($temps) > 0)
                                        @foreach ($temps as $item)
                                            <tr>
                                                <td>{{ $item->nama_barang }}</td>
                                                <td>{{ $item->batch }}</td>
                                                <td>{{ $item->expired }}</td>
                                                <td>{{ $item->product->satuan }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>@rupiah( $item->harga_beli)</td>
                                                <td>{{ $item->diskon }}%</td>
                                                <td>@rupiah($item->sub_total)</td>
                                                <td class="text-center">
                                                    <i wire:click='deleteCart({{ $item->id }})'
                                                        class="fas fa-trash"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="10" class="text-center">Item masih kosong</td>
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
            }, 5000);

        }
    </script>
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
