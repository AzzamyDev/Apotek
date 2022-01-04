<section class="section">
    <div class="section-header row g-2">
        <div class="col">
            <h1>Detail Transaksi</h1>
        </div>
        <div class="col-auto">

        </div>
    </div>

    <div class="section-body">
        <div class="container">
            <div class="section-title">Data Transaksi</div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Tanggal</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $transaksi->created_at->format('d-m-Y') }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Nomer Transaksi</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $transaksi->no_transaksi }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Tipe Transaksi</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $transaksi->tipe_transaksi }}</h6>
                        </div>
                    </div>
                    @if ($transaksi->tipe_transaksi == 'Halodoc')
                        <div class="row">
                            <div class="col-sm-3 ">
                                <h6>Customer</h6>
                            </div>
                            <div class="col-sm ">
                                <h6 class="text-left">{{ $transaksi->pasien }}</h6>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Cara Bayar</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $transaksi->tipe_bayar }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Bayar Via</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $transaksi->bayar != null ? $transaksi->bayar : '-' }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h6>Keterangan</h6>
                        </div>
                        <div class="col-sm ">
                            <h6 class="text-left">{{ $transaksi->keterangan }}</h6>
                        </div>
                    </div>
                </div>


                <div class="col-6"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title">Data Barang</div>
                    <div style="max-height: 300px" class="table-responsive">
                        <table class="table table-hover table-md text-nowrap table-bordered">
                            <thead>
                                <tr>
                                    <th style="min-width: 50px">No</th>
                                    <th style="min-width: 200px">Nama Obat</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Jenis Harga</th>
                                    <th>SubTotal</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($list) > 0)
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>@rupiah( $item->harga_jual)</td>
                                            <td>{{ $item->jenisHarga->name }}</td>
                                            <td>@rupiah($item->sub_total)</td>
                                            <td class="text-center">
                                                <i style="cursor: pointer" class="fas fa-redo"> Retur</i>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="10" class="text-center">Item masih kosong</td>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right">
                                        <h5>Total</h5>
                                    </td>
                                    <td>
                                        <h5>@rupiah($transaksi->total_real)</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
