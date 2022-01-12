<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-dark">Koreksi Stok</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <form autocomplete="off">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-6">
                        <label class="text-dark">Jumlah Koreksi</label>
                        <div class="input-group">
                            <input autocomplete="off" wire:model='qty' required value="{{ old('qty') }}" id="qty"
                                name="qty" type="number" class="form-control @error('qty')is-invalid @enderror">
                        </div>
                        @error('qty')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-dark" for="inputState">Alasan</label>
                        <select wire:model='alasan' id="inputState" class="form-control">
                            <option selected>Pilih...</option>
                            <option>Retur Pembelian</option>
                            <option>Kesalahan Input</option>
                            <option>Penyesuaian Fisik Barang</option>
                            <option>Lainnya</option>
                        </select>
                        @error('alasan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($alasan == 'Lainnya')
                        <div class="form-group col-12">
                            <label class="text-dark">Keterangan</label>
                            <div class="input-group">
                                <textarea autocomplete="off" wire:model='keterangan' required
                                    value="{{ old('keterangan') }}" id="keterangan" name="keterangan" type="text"
                                    class="form-control @error('keterangan')is-invalid @enderror"></textarea>
                            </div>
                            @error('keterangan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer flex justify-content-center">
                <small class="text-danger font-weight-bolder">Harap hati-hati</small>
                <small class="text-dark font-weight-bolder">Koreksi stok akan memperbaharui stok yang sebelumnya</small>
                <button class="btn btn-block btn-success" type="button" wire:click="submit()">Simpan</button>
            </div>
        </form>
    </div>
</div>
