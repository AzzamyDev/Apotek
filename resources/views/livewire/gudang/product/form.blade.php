<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-dark">{{ $product_id != null ? 'Edit Data' : 'Form' }} Barang </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <form autocomplete="off">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-dark">Nama Barang</label>
                        <div class="input-group">
                            <input autocomplete="off" wire:model='name' required value="{{ old('name') }}" id="name"
                                name="name" type="text" class="form-control @error('name')is-invalid @enderror">
                        </div>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-dark" for="inputState">Golongan Obat</label>
                        <select wire:model='golongan' id="inputState" class="form-control">
                            <option selected>Pilih...</option>
                            <option>Bebas</option>
                            <option>Bebas Terbatas</option>
                            <option>Keras</option>
                            <option>Psikotropika</option>
                            <option>Narkotika</option>
                        </select>
                        @error('golongan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 mt-2">
                        <label class="text-dark">Lokasi Rak</label>
                        <div class="input-group">
                            <input wire:model='lokasi' required value="{{ old('lokasi') }}" id="lokasi" name="lokasi"
                                type="text" class="form-control @error('lokasi')is-invalid @enderror">
                        </div>
                        @error('lokasi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label class="text-dark" for="inputState">Tipe Barang</label>
                        <select wire:model='tipe_barang_id' id="inputState" class="form-control">
                            <option selected>Pilih...</option>
                            @foreach ($tipe_barang as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('tipe_barang_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 mt-2">
                        <label class="text-dark">Harga Beli (HNA)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    RP.
                                </div>
                            </div>
                            <input wire:model='harga' required value="{{ old('harga') }}" id="harga" name="harga"
                                type="number" class="form-control @error('harga')is-invalid @enderror">
                        </div>
                        @error('harga')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="inputState" class="text-dark">Tipe Harga</label>
                        <select wire:model='tipe_harga_id' id="inputState" class="form-control">
                            <option selected>Pilih...</option>
                            @foreach ($tipe_harga as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('tipe_harga_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label for="inputState" class="text-dark">Satuan</label>
                        <select wire:model='satuan' id="inputState" class="form-control">
                            <option selected>Pilih...</option>
                            @foreach ($satuans as $item)
                                <option value="{{ strtoupper($item->name) }}">
                                    {{ strtoupper($item->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('satuan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3 mt-2">
                        <label class="text-dark">Minimal Stok</label>
                        <div class="input-group">
                            <input wire:model='min_stok' required value="{{ old('min_stok') }}" id="min_stok"
                                name="min_stok" type="number"
                                class="form-control @error('min_stok')is-invalid @enderror">
                        </div>
                        @error('min_stok')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3 mt-2">
                        <label class="text-dark">Maksimal Stok</label>
                        <div class="input-group">
                            <input wire:model='max_stok' required value="{{ old('max_stok') }}" id="max_stok"
                                name="max_stok" type="number"
                                class="form-control @error('max_stok')is-invalid @enderror">
                        </div>
                        @error('max_stok')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-block btn-success" type="button" wire:click="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
