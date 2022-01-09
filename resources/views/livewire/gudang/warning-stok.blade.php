<section class="section">

    <div class="section-header row">
        <div class="col">
            <h1>Warning Stok</h1>
        </div>
    </div>
    <div class="section-body">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover text-nowrap ">
                            <thead class="table-primary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Golongan Obat</th>
                                    <th>Lokasi Rak</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
                                    <th>Min Stok</th>
                                    <th>Jenis Harga</th>
                                    <th>Harga Jual</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $item)
                                    <tr class="text-center">
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td class="text-left">{{ $item->name }}</td>
                                        <td>{{ $item->golongan }}</td>
                                        <td>{{ $item->lokasi }}</td>
                                        <td>{{ $item->satuan }}</td>
                                        <td>{{ $item->stok }}</td>
                                        <td>{{ $item->min_stok }}</td>
                                        <td>{{ $item->JenisHarga->name }}</td>
                                        <td>@rupiah(($item->harga * (1+($item->jenisHarga->persentase/100))) * 1.1)</td>
                                        <td>
                                            <a href="{{ route('record', $item->id) }}"
                                                class="btn btn-outline-primary btn-sm btn-block">Kartu Stok</a>
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
        {{ $products->links() }}
    </div>
</section>
