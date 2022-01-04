<section class="section">
    <div class="section-header row g-2">
        <div class="col">
            <h1>Daftar Tipe Barang</h1>
        </div>
        <div class="col-3">
            <div><button class="btn btn-block btn-primary">Tambah Tipe Barang</button></div>
        </div>
    </div>

    <div class="section-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Tipe Barang</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($users as $user)
                                            <tr>
                                                <td class="text-center">{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->jabatan->nama }}</td>
                                                <td>{{ $user->no_telpon }}</td>
                                                <td>
                                                    @if ($user->status == 'Active')
                                                        <div class="badge badge-success">Active</div>
                                                    @else
                                                        <div class="badge badge-danger">Off</div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('karyawan.show', $user->id) }}"
                                                        class="btn btn-sm btn-secondary">Detail</a>
                                                    <a href="{{ route('karyawan.edit', $user->id) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
