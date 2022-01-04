@push('toast-css')
    <link rel="stylesheet" href="{{ asset('node_modules/izitoast/dist/css/iziToast.min.css') }}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">

@endpush
<section class="section">
    <div wire:ignore>
        <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <livewire:admin.karyawan.form>
        </div>
    </div>
    <div class="section-header row g-2">
        <div class="col">
            <h1>Daftar Karyawan</h1>
        </div>
        <div class="col-auto">
            <div><button type="button" class="btn btn-block btn-primary"
                    wire:click="$emitTo('admin.karyawan.form','open','')">Tambah
                    Karyawan</button>
            </div>
        </div>
    </div>

    <div class="  section-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-md" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Nomer Telpon</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->jabatan }}</td>
                                        <td>{{ $user->telepon }}</td>
                                        <td>
                                            @if ($user->status == 'Active')
                                                <div class="badge badge-success">Active</div>
                                            @else
                                                <div class="badge badge-danger">Off</div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button type="button"
                                                wire:click="$emitTo('admin.karyawan.form','open','{{ $user->id }}')"
                                                class="btn btn-sm btn-primary">Edit</button>
                                            <button type="button" wire:click="destroy({{ $user->id }})"
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
