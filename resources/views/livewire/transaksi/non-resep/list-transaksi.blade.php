@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
    <!-- Page Specific JS File -->

@endpush
<section class="section">

    <div class="section-header row">
        <div class="col">
            <h1>Detail Laporan Penjualan Non Resep</h1>
        </div>
        <div class="col-auto">
            <select style="width: 150px" wire:model="cari" class="form-control">
                <option selected value="">Semua</option>
                <option value="Umum">Umum</option>
                <option value="Halodoc">Halodoc</option>
            </select>
        </div>
    </div>
    <div class="section-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <h4 class="text-primary">Total : @rupiah($total)</h4>
                </div>
                <div class="col"></div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Filter berdasarkan waktu Shift</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </div>
                            </div>
                            <input type="date-range" name="daterange" class="form-control daterange-cus">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-md table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Tanggal</th>
                                    <th>Tipe Transaksi</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Jual</th>
                                    <th>Jenis Harga</th>
                                    <th>Qty</th>
                                    <th>Sub Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($transaksis->count() > 0)
                                    @foreach ($transaksis as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td>{{ date('d-m-Y H:i', strtotime($item->created_at)) }}</td>
                                            <td>{{ $item->tipe_transaksi }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>@rupiah($item->harga_jual)</td>
                                            <td>{{ $this->getJenisHarga($item->jenis_harga_id) }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>@rupiah($item->sub_total)</td>
                                            <td class="text-center">
                                                <a href="{{ route('detail-transaksi', $item->transaksi_id) }}"
                                                    class="btn btn-primary btn-sm btn-block">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="9" class="text-center">Tidak ada data</td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-footer d-flex justify-content-center mt-3">
        {{-- {{ $transaksis->links() }} --}}
    </div>
</section>

@push('toast')
    <!-- Page Specific JS File -->
    <script src="{{ asset('node_modules/izitoast/dist/js/iziToast.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('assets/js/page/modules-toastr.js') }}"></script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                "timePicker": true,
                "timePicker24Hour": true,
                startDate: @js($start_),
                endDate: @js($end_),
                locale: {
                    format: 'DD-MM-YYYY HH:mm'
                },
            }, function(start, end, label) {
                @this.start = start.format('YYYY-MM-DD HH:mm');
                @this.end = end.format('YYYY-MM-DD HH:mm');
                @this.start_ = start.format('YYYY-MM-DD HH:mm');
                @this.end_ = end.format('YYYY-MM-DD HH:mm');
            });
        });
    </script>
    <script>
        function show(message) {
            iziToast.success({
                message: message,
                position: "topRight",
            });
        }
    </script>
    @if (session()->has('message'))
        <script>
            iziToast.success({
                message: "{{ session('message') }}",
                position: "topRight",
            });
            {{ Session::forget('message') }}
        </script>
    @endif
@endpush
@push('custom_js')
    <!-- Page Specific JS File -->
    <script src="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('node_modules/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script>
@endpush
