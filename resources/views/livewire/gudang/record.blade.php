@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
<section class="section">
    <div class="section-header row g-2">
        <div class="col-7">
            <h1>Kartu Stok</h1>
            <div class="row mt-3">
                <div class="col-3 my-1">ID Barang</div>
                <div class="col my-1">: {{ $product->id }}</div>
            </div>
            <div class="row">
                <div class="col-3 my-1">Nama Barang</div>
                <div class="col my-1">: <strong> {{ $product->name }}</strong></div>
            </div>
        </div>
        <div class="col-5 mt-3">
            <div class="form-group ">
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
    </div>

    <div class="section-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="table-responsive mt-4">
                        <table class="table table-md table-bordered table-hover">
                            <thead class="table-primary">
                                <tr class="text-center">
                                    <th>Tanggal</th>
                                    <th>Referensi</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Sisa</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->created_at }}</td>
                                        <td class="text-left">
                                            <a
                                                href="{{ $item->no_faktur != null ? route('to-faktur', $item->no_faktur) : route('to-trx', $item->no_transaksi) }}">{{ $item->no_faktur != null ? $item->no_faktur : $item->no_transaksi }}</a>
                                        </td>
                                        @if ($item->record == 'In')
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td class="text-center"></td>
                                        @else
                                            <td class="text-center"></td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                        @endif
                                        <td class="text-center">{{ $item->sisa_stok }}</td>
                                        <td class="text-left"><span
                                                class="badge badge-sm badge-{{ $item->record == 'Out' ? 'danger' : 'primary' }}">{{ $item->keterangan }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-center table-primary">
                                    <th colspan="2">Total</th>
                                    <th>{{ $records->where('record', 'In')->sum('qty') }}</th>
                                    <th>{{ $records->where('record', 'Out')->sum('qty') }}</th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-footer d-flex justify-content-center mt-3">
        {{-- {{ $records->links() }} --}}
    </div>
</section>
@push('toast')
    <script src="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script>
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
@endpush
