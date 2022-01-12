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
                                    <tr class="text-center align-middle">
                                        <td class="align-middle">{{ $loop->index + 1 }}</td>
                                        <td class="text-left align-middle">{{ $item->name }}</td>
                                        <td class="align-middle">{{ $item->golongan }}</td>
                                        <td class="align-middle">{{ $item->lokasi }}</td>
                                        <td class="align-middle">{{ $item->satuan }}</td>
                                        <td class="align-middle">{{ $item->stok }}</td>
                                        <td class="align-middle">{{ $item->min_stok }}</td>
                                        <td class="align-middle">{{ $item->JenisHarga->name }}</td>
                                        <td class="align-middle">@rupiah(($item->harga *
                                            (1+($item->jenisHarga->persentase/100))) * 1.1)</td>
                                        <td class="align-middle">
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
