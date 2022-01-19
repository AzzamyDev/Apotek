<div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered " role="document">
    <div class="modal-content bg-secondary">
        <div class="modal-header">
            <h5 class="modal-title text-dark">Form Racikan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <form autocomplete="off">
            <div class="modal-body">
                <h5 class="text-dark">No Resep : {{ $no_resep }}</h5>
                <div class="row mb-1">
                    <div class="col-2 text-left pt-3 text-dark">Nama Racikan</div>
                    <div class="col-3">
                        <input wire:model="name" type="text" class="form-control" placeholder="Masukan disini">
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-2 text-left pt-3 text-dark">Sediaan</div>
                    <div class="col-3">
                        <select wire:model="sediaan" class="form-control form-control-sm">
                            <option selected>Pilih Sediaan</option>
                            <option value="Kapsul">Kapsul</option>
                            <option value="Puyer">Puyer</option>
                            <option value="Salep">Salep</option>
                            <option value="Sirup">Sirup</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2 text-left pt-3 text-dark">Aturan Pakai</div>
                    <div class="col-3">
                        <select wire:model="aturan" class="form-control form-control-sm">
                            <option selected>Pilih Sediaan</option>
                            @foreach ($aturans as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i
                                        class="fas fa-{{ $product != null ? 'pills' : 'search' }}"></i>
                                </div>
                            </div>
                            <input wire:model='search' autocomplete="off" type="text" list="data_obat_racik"
                                class="form-control @if ($product != null)is-valid @else 'is-invalid' @endif" id="search" placeholder="Cari Obat">
                            <div style="max-height: 100px; overflow-y: auto">
                                <datalist id="data_obat_racik">
                                    @foreach ($products as $item)
                                        <option value="{{ $item->name }}">Sisa stok :
                                            {{ $item->stok }}
                                            @foreach ($harga as $i)
                                                | {{ $i->name }} :
                                                @rupiah((1.1 * $item->harga)*(1+($i->persentase/100)))
                                            @endforeach
                                        </option>
                                    @endforeach
                                </datalist>
                            </div>
                            @error('search')
                                <script>
                                    show('{{ $message }}')
                                </script>
                            @enderror
                            @error('product_id')
                                <script>
                                    show('{{ $message }}')
                                </script>
                            @enderror
                        </div>
                    </div>
                    <div class="col-2 px-0">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend ">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            </div>
                            <input disabled wire:model.defer="harga_beli" autocomplete="off" type="number"
                                aria-describedby="helper"
                                class="form-control @error('harga_beli') is-invalid @else '' @enderror" id="harga_beli"
                                placeholder="Rp.0">
                            @error('harga_beli')
                                <script>
                                    show('{{ $message }}')
                                </script>
                            @enderror
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-cart-plus"></i></div>
                            </div>
                            <input wire:model.defer="qty" autocomplete="off" type="number"
                                class="form-control @error('qty') is-invalid @else '' @enderror" id="qty"
                                placeholder="Qty">
                            @error('qty')
                                <script>
                                    show('{{ $message }}')
                                </script>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <div class="input-group">
                            <button {{ $product != null ? '' : 'disable' }} type="button" wire:click="addBarang()"
                                class="btn btn-primary btn-block"><span><i class="fas fa-plus"></i></span>
                                Tambahkan</button>
                        </div>
                    </div>
                </div>
                <div class=" tableresponsive">
                    <table style="max-height: 180px"
                        class="table table-hover table-md text-nowrap table-sm align-middle p-2">
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
                            @if (count($temps) > 0)
                                @foreach ($temps as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>@rupiah( $item->harga_jual)</td>
                                        <td>{{ $item->jenisHarga->name }}</td>
                                        <td>@rupiah($item->sub_total)</td>
                                        <td class="text-center">
                                            <i style="cursor: pointer" wire:click='deleteItem({{ $item->id }})'
                                                class="fas fa-trash"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center"><small>Belum ada data</small></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer row">
                <div class="col">
                    <h4> Total : @rupiah($total)</h4>
                </div>
                <div class="col-auto">
                    <button data-dismiss="modal" class="btn btn-danger" type="button"
                        wire:click="resetModal">Batal</button>
                    <button class="btn btn-success" type="button" wire:click="simpanTransaksi">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
