<section class="section">
    <div class="section-header row g-2">
        <div class="col">
            <h1>Nilai Persediaan Barang</h1>
        </div>
        <div class="col-auto pt-2">
            <h5>Tanggal : <span class="text-primary">{{ $tanggal }}</span></h5>
        </div>
    </div>

    <div class="section-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 mb-4">
                    <h4>Total : <span class="text-primary">@rupiah($total)</span></h4>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-bordered table-hover">
                            <thead class="text-center table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th style="min-width: 140px">Nama Barang</th>
                                    <th>Golongan Obat</th>
                                    <th>Lokasi Rak</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $item)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->index + 1 }}</td>
                                        <td class="text-center align-middle">{{ $item->id }}</td>
                                        <td class="text-left align-middle">{{ $item->name }}</td>
                                        <td class="text-center align-middle">{{ $item->product->golongan }}</td>
                                        <td class="text-center align-middle">{{ $item->product->lokasi }}</td>
                                        <td class="text-center align-middle">{{ $item->product->satuan }}</td>
                                        <td class="text-center align-middle">{{ $item->stok_akhir }}</td>
                                        <td class="text-center align-middle">@rupiah($item->harga)</td>
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
