@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
<section class="section">
    <div wire:ignore>
        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalTitle">Cancel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Yakin mau cancel Stok Opname ?
                    </div>
                    <div class="modal-footer">
                        <button wire:click="resetDelete" type="button" class="btn btn-danger"
                            data-dismiss="modal">Batal</button>
                        <button wire:click='deleteDraf' type="button" class="btn btn-primary">Iya</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="section-header row g-2">
        <div class="col">
            <h1>Riwayat Stok Opname</h1>
        </div>
        <div class="col-auto" wire:loading wire:target="create">
            <div class="badge badge-sm badge-primary mt-1"><i class="fas fa-cog"></i> Mohon Tunggu..</div>
        </div>
        <div class="col-auto" wire:loading.remove wire:target="create">
            <button wire:click="create" class="btn btn-outline-primary alignt-middle">Buat Opname</button>
        </div>
    </div>
    <div class="section-body">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-6 mb-3">

                </div>
                <div class="col-6 mb-3">
                    <div class="form-group">
                        <label>Filter berdasarkan waktu</label>
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
                        <table class="table table-striped table-sm table-bordered">
                            <thead class="text-center table-primary">
                                <tr>
                                    <th class="align-middle">No</th>
                                    <th class="align-middle">ID</th>
                                    <th class="align-middle">Tanggal Open</th>
                                    <th class="align-middle">Petugas</th>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle">Tanggal Close</th>
                                    <th class="align-middle" colspan="3">Lihat</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($opname) > 0)
                                    @foreach ($opname as $item)
                                        <tr>
                                            <td class="text-center align-middle">{{ $loop->index + 1 }}</td>
                                            <td class="text-center align-middle">{{ $item->id }}</td>
                                            <td class="text-center align-middle">{{ $item->created_at }}</td>
                                            <td class="text-center align-middle">{{ $item->petugas->name }}</td>
                                            <td class="text-center align-middle">
                                                @switch($item->status)
                                                    @case('Open')
                                                        <span
                                                            class="badge badge-sm badge-secondary text-dark">{{ $item->status }}</span>
                                                    @break
                                                    @case('Close')
                                                        <span
                                                            class="badge badge-sm badge-success">{{ $item->status }}</span>
                                                    @break
                                                    @case('Cancel')
                                                        <span
                                                            class="badge badge-sm badge-danger">{{ $item->status }}</span>
                                                    @break
                                                    @default

                                                @endswitch
                                            </td>
                                            <td class="text-center align-middle px-1">
                                                {{ $item->waktu_close != null ? $item->waktu_close : '-' }}</td>
                                            @switch($item->status)
                                                @case('Open')
                                                    <td></td>
                                                    <td class="text-center align-middle">
                                                        <a href="{{ route('form-opname', $item->id) }}"
                                                            class="btn btn-block btn-sm btn-primary">Input</a>
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <button type="button" wire:click='open({{ $item->id }})'
                                                            class="btn btn-block btn-sm btn-danger">Cancel</button>
                                                    </td>

                                                @break
                                                @case('Close')
                                                    <td class="text-center align-middle">
                                                        <a href="{{ route('detail-opname', $item->id) }}" type="button"
                                                            class="btn btn-block btn-sm btn-dark">Detail</a>
                                                    </td>
                                                    <td class="text-center align-middle px-1">
                                                        <a href="{{ route('nilai-opname', $item->id) }}" type="button"
                                                            class="btn btn-block btn-sm btn-primary">Nilai
                                                            Persediaan</a>
                                                    </td>
                                                    <td class="text-center px-1">
                                                        <a href="{{ route('nbh-opname', $item->id) }}" type="button"
                                                            class="btn btn-block btn-sm btn-success">NBH</a>
                                                    </td>
                                                    <td>-</td>
                                                @break
                                                @case('Cancel')
                                                    <td></td>
                                                    <td class="text-center align-middle">
                                                        -
                                                    </td>
                                                    <td></td>
                                                    <td>-</td>
                                                @break
                                                @default

                                            @endswitch
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="7" class="text-center">Data tidak di temukan</td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-footer d-flex justify-content-center mt-3">
        {{ $opname->links() }}
    </div>
</section>
@push('toast')
    <!-- Page Specific JS File -->
    <script src="{{ asset('node_modules/izitoast/dist/js/iziToast.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('assets/js/page/modules-toastr.js') }}"></script>
    <script>
        window.addEventListener('refresh', event => {
            Livewire.emit('render')
            iziToast.success({
                title: "Success",
                message: event.detail.message,
                position: "topRight",
            });
        })
        window.livewire.on('toggleFormModalDelete', () => {
            Livewire.emit('render');
            $('#deleteModal').appendTo('body');
            $('#deleteModal').modal('toggle');
        });
    </script>
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
    @if (session('message'))
        <script>
            iziToast.success({
                title: "Success",
                message: "{{ session('message') }}",
                position: "topRight",
            });
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
