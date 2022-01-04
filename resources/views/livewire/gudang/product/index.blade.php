@push('toast-css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
<section class="section">
    <div wire:ignore>
        <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <livewire:gudang.product.form>
        </div>
    </div>
    <div class="section-header row g-2">
        <div class="col">
            <h1>Daftar Barang</h1>
        </div>
        <div class="col-auto">
            <input wire:model="search" class="form-control" type="search" placeholder="Cari Barang" aria-label="Search"
                data-width="250">
        </div>
        <div class="col-auto">

            <div><button type="button" class="btn btn-block btn-primary"
                    wire:click="$emitTo('gudang.product.form','open','')">Tambah
                    Barang</button>
            </div>
        </div>
    </div>

    <div class="section-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th style="min-width: 170px">Nama Barang</th>
                                    <th>Golongan Obat</th>
                                    <th>Lokasi Rak</th>
                                    <th>Harga Beli</th>
                                    <th class="text-center" style="min-width: 120px">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($products) > 0)
                                    @foreach ($products as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->golongan }}</td>
                                            <td>{{ $item->lokasi }}</td>
                                            <td>{{ $item->harga }}</td>
                                            <td class="text-center">
                                                <div class="cform-check form-switch">
                                                    <input {{ $item->status ? 'checked' : '' }} type="checkbox"
                                                        wire:change.lazy="setStatus({{ $item->id }})" role="switch"
                                                        class="form-check-input" id="status_id">
                                                    <span
                                                        class="badge badge-{{ $item->status ? 'success' : 'danger' }}">{{ $item->status ? 'Active' : 'Non Active' }}</span>
                                                    {{-- <label class="form-check-label"
                                                        for="status_id">{{ $item->status ? 'Active' : 'Non Active' }}</label> --}}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    wire:click="$emitTo('gudang.product.form','open','{{ $item->id }}')"
                                                    class="btn btn-sm btn-primary">Edit</button>
                                                <button type="button" wire:click="destroy({{ $item->id }})"
                                                    class="btn btn-sm btn-danger">Hapus</button>
                                            </td>
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
        {{ $products->links() }}
    </div>
</section>
@push('toast')
    <!-- Page Specific JS File -->
    <script src="{{ asset('node_modules/izitoast/dist/js/iziToast.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('assets/js/page/modules-toastr.js') }}"></script>
    <script>
        function toogleClick(_this, id, state) {
            Livewire.emit('change', id, state);
        }
        window.livewire.on('toggleFormModal', () => {
            $('#form-modal').appendTo('body');
            $('#form-modal').modal('toggle');
        });
        window.addEventListener('refresh', event => {
            Livewire.emit('render')
            iziToast.success({
                title: "Success",
                message: event.detail.message,
                position: "topRight",
            });
        })
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
