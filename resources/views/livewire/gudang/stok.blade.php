<section class="section">

    <div class="section-header row">
        <div class="col">
            <h1>Stok Barang</h1>
        </div>
        <div class="col-auto">
            <select style="width: 150px" wire:model="type" class="form-control">
                <option selected value="">Semua</option>
                @foreach ($tipe as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="section-body">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col">
                    @if ($search == null)
                        <h4 class="text-primary">Total Barang Active: {{ $total_barang }}</h4>
                    @endif
                </div>
                <div class="col-auto my-1">
                    <input wire:model="search" class="mb-2 form-control" type="search" placeholder="Cari Barang"
                        aria-label="Search">
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover text-nowrap">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Golongan Obat</th>
                                    <th>Tipe Barang</th>
                                    <th>Lokasi Rak</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
                                    <th>Jenis Harga</th>
                                    <th>Harga Jual</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($products as $item)
                                    <tr>
                                        <td class="align-middle">{{ $loop->index + 1 }}</td>
                                        <td class="text-left align-middle">{{ $item->name }}</td>
                                        <td class="align-middle">{{ $item->golongan }}</td>
                                        <td class="align-middle">{{ $item->TipeBarang->name }}</td>
                                        <td class="align-middle">{{ $item->lokasi }}</td>
                                        <td class="align-middle">{{ $item->satuan }}</td>
                                        <td class="align-middle">{{ $item->stok }}</td>
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
