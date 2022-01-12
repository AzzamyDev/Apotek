@push('toast-css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
<section class="section">
    <div class="section-header row g-2">
        <div class="col">
            <h1>Draft Stok Opname</h1>
        </div>
    </div>

    <div class="section-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    <div wire:loading class="mt-3">
                        <span class=" badge badge-success"><i class="fas fa-cog"> </i> Menyimpan..</span>
                    </div>
                    <button wire:click="simpan" wire:loading.remove class="mt-2 btn btn-outline-primary w-25">Simpan
                        Opname</button>
                </div>
                <div class="col-4 mb-3">
                    <input id="cari" wire:model="search" class="form-control" type="search" placeholder="Cari Barang"
                        aria-label="Search" autocomplete="off">
                    <small class="ml-2">Ketik 4 huruf nama barang & Press F4 untuk Focus</small>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-bordered table-hover">
                            <thead class="text-center table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th style="min-width: 140px">Nama Barang</th>
                                    <th>Terakhir Update</th>
                                    <th>Lokasi Rak</th>
                                    <th>Stok Terakhir</th>
                                    <th>Live Stok</th>
                                    <th style="width: 90px">Edit Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($products) > 0)
                                    @foreach ($products as $item)
                                        <tr class="{{ $item->status ? 'table-secondary' : '' }}">
                                            <td class="text-center align-middle">{{ $loop->index + 1 }}</td>
                                            <td class="text-center align-middle">{{ $item->id }}</td>
                                            <td class="text-left align-middle">{{ $item->name }}</td>
                                            <td class="text-left align-middle">
                                                <span>{{ \Carbon\Carbon::parse($item->product->updated_at)->diffForHumans() }}</span>
                                            </td>
                                            <td class="text-center align-middle">{{ $item->product->lokasi }}</td>
                                            <td class="text-center align-middle">{{ $item->stok_terakhir }}</td>
                                            <td class="text-center align-middle">{{ $item->product->stok }}</td>
                                            <td class="text-center align-middle">
                                                <input type="number`" wire:model.lazy="qty"
                                                    wire:change="save({{ $item->id }})"
                                                    wire:keydown.enter='$refresh' wire:keydown.tab='$refresh'
                                                    class="form-control form-control-sm">
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
        window.livewire.on('toggleFormModalDelete', () => {
            Livewire.emit('render');
            $('#deleteModal').appendTo('body');
            $('#deleteModal').modal('toggle');
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
    <script>
        $(document).ready(function() {
            $('#cari').focus();
        })
        document.addEventListener("keydown", function(event) {
            if (event.keyCode == 115) {
                $('#cari').focus();
            }
        });
    </script>
@endpush
