@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
    <!-- Page Specific JS File -->
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

@endpush
<section class="section">

    <div class="section-header row">
        <div class="col">
            <h1>Daftar Faktur</h1>
        </div>
        <div class="col-auto">
            <input wire:model="cari" class="form-control" type="search" placeholder="Cari Faktur" aria-label="Search"
                data-width="250">
        </div>
        <div class="col-auto">

            <div><a data-turbolinks="false" href="{{ route('faktur-form') }}" type="button"
                    class="btn btn-block btn-primary">Tambah
                    Faktur</a>
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col"></div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Filter berdasarkan tanggal</label>
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
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Supplier</th>
                                    <th>Nomer Faktur</th>
                                    <th>Nomer SP</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Keterangan</th>
                                    <th>Items</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fakturs as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->supplier->name }}</td>
                                        <td>{{ $item->no_faktur }}</td>
                                        <td>{{ $item->no_sp }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                                        <td>@rupiah($item->total_real)</td>
                                        <td>{{ $item->keterangan != null ? $item->keterangan : '-' }}</td>
                                        <td>{{ $item->items }}</td>
                                        <td class="text-center">
                                            <a data-turbolinks="false" href="{{ route('faktur-detail', $item->id) }}"
                                                class="btn btn-primary btn-sm btn-block">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-footer d-flex justify-content-center mt-3">
        {{ $fakturs->links() }}
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
                startDate: moment().startOf('day'),
                endDate: moment().endOf('day'),
                locale: {
                    format: 'DD-MM-YYYY HH:mm'
                },
            }, function(start, end, label) {
                @this.start = start.format('YYYY-MM-DD HH:mm');
                @this.end = end.format('YYYY-MM-DD HH:mm');
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
    <script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('node_modules/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
@endpush
