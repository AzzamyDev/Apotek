@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
<section class="section">
    <div wire:ignore>
        <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <livewire:gudang.form-koreksi>
        </div>
    </div>
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
            <button wire:click="$emitTo('gudang.form-koreksi','open',{{ $product->id }})"
                class="mt-3 btn btn-outline-danger btn-block btn-sm w-25 ">Koreksi Stok</button>
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
                <div class="col-auto">
                    <div class="table-responsive mt-4">
                        <table class="table table-md table-bordered table-hover align-middle">
                            <thead class="table-primary">
                                <tr class="text-center">
                                    <th>Tanggal</th>
                                    <th>Referensi</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Koreksi</th>
                                    <th>Sisa</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($records as $item)
                                    <tr>
                                        <td class="align-middle">{{ $item->created_at }}</td>
                                        <td class="text-left align-middle">
                                            @switch($item->record)
                                                @case('In')
                                                    @if ($item->no_faktur != null)
                                                        <a href="{{ route('to-faktur', $item->no_faktur) }}">{{ $item->no_faktur }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('to-trx', $item->no_transaksi) }}">{{ $item->no_transaksi }}
                                                        </a>
                                                    @endif
                                                @break
                                                @case('Out')
                                                    @if ($item->no_transaksi != null)
                                                        <a
                                                            href="{{ route('detail-transaksi-resep', $item->no_transaksi) }}">{{ $item->no_transaksi }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('to-faktur', $item->no_faktur) }}">{{ $item->no_faktur }}
                                                        </a>
                                                    @endif
                                                @break
                                                @case('Koreksi')
                                                    @php
                                                        $ref = explode('-', $item->keterangan);
                                                    @endphp
                                                    <span>{{ $item->record . ' oleh ' . $ref[0] }}
                                                    </span>
                                                @break
                                                @default

                                            @endswitch
                                        </td>
                                        @switch($item->record)
                                            @case('In')
                                                <td class="align-middle">{{ $item->qty }}</td>
                                                <td class="align-middle"></td>
                                                <td class="align-middle"></td>
                                            @break
                                            @case('Out')
                                                <td class="align-middle"></td>
                                                <td class="align-middle">{{ $item->qty }}</td>
                                                <td class="align-middle"></td>
                                            @break
                                            @case('Koreksi')
                                                <td class="align-middle"></td>
                                                <td class="align-middle"></td>
                                                <td class="align-middle">{{ $item->qty }}</td>
                                            @break
                                            @default

                                        @endswitch
                                        <td class="align-middle">{{ $item->sisa_stok }}</td>
                                        <td class="text-left align-middle">
                                            <span
                                                class="badge badge-sm w-100 badge-{{ $item->record == 'Out' ? 'danger' : 'primary' }}">
                                                @switch($item->record)
                                                    @case('Koreksi')
                                                        @php
                                                            $ref = explode('-', $item->keterangan);
                                                        @endphp
                                                        {{ $ref[1] }}
                                                    @break
                                                    @default
                                                        {{ $item->keterangan }}
                                                @endswitch
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-center table-primary">
                                    <th colspan="2">Total</th>
                                    <th>{{ $records->where('record', 'In')->where('keterangan', 'Pembelian')->sum('qty') }}
                                    </th>
                                    <th>{{ $records->where('record', 'Out')->where('keterangan', 'Penjualan')->sum('qty') }}
                                    </th>
                                    <th colspan="3"></th>
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
        window.livewire.on('toggleFormModal', () => {
            $('#form-modal').appendTo('body');
            $('#form-modal').modal('toggle');
        });
        window.addEventListener('save', event => {
            Livewire.emit('render')
            iziToast.success({
                title: "Success",
                message: event.detail.save,
                position: "topRight",
            });
        })
    </script>
@endpush
@push('js_lib')
    <!-- JS Libraies -->
    <script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

@endpush
@push('custom_js')
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
@endpush
