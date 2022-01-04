@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
@endpush
<section class="section">
    <div wire:ignore>
        <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <livewire:admin.aturan-pakai.form>
        </div>
    </div>
    <div class="section-header row g-2">
        <div class="col">
            <h1>Daftar Aturan Pakai</h1>
        </div>
        <div class="col-auto">
            <div><button type="button" class="btn btn-block btn-primary"
                    wire:click="$emitTo('admin.aturan-pakai.form','open','')">Tambah
                    Aturan Pakai</button>
            </div>
        </div>
    </div>

    <div class="  section-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-7">
                    <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Nama Aturan Pakai</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aturan as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">
                                            <button type="button"
                                                wire:click="$emitTo('admin.aturan-pakai.form','open','{{ $item->id }}')"
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
