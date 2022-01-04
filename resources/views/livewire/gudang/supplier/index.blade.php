@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
<section class="section">
    <div wire:ignore>
        <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <livewire:gudang.supplier.form>
        </div>
    </div>
    <div class="section-header row g-2">
        <div class="col">
            <h1>Daftar Supplier</h1>
        </div>
        <div class="col-auto">
            <div><button type="button" class="btn btn-block btn-primary"
                    wire:click="$emitTo('gudang.supplier.form','open','')">Tambah
                    Supplier</button>
            </div>
        </div>
    </div>

    <div class="  section-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nama Supplier</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center">Telepon</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->id }}</td>
                                        <td class="text-center">{{ $item->name }}</td>
                                        <td class="text-center">{{ $item->alamat }}</td>
                                        <td class="text-center">{{ $item->telepon }}</td>
                                        <td class="text-center">
                                            <button type="button"
                                                wire:click="$emitTo('gudang.supplier.form','open','{{ $item->id }}')"
                                                class="btn btn-sm btn-primary">Edit</button>
                                            <button type="button" wire:click="destroy({{ $item->id }})"
                                                class="btn btn-sm btn-danger">Hapus</button>
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
    </script>
    @if (session()->has('success'))
        <script>
            $(document).ready(function() {
                iziToast.success({
                    title: "Success",
                    message: "{{ session('success') }}",
                    position: "topRight",
                });
            });
        </script>
    @endif
@endpush
