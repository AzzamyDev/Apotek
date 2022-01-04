<div class="modal-dialog">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h5 class="modal-title text-white">{{ $tipe_id != null ? 'Edit Data' : 'Form' }} TIpe Barang </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <form autocomplete="off">
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-white">Nama Tipe Barang</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-box-open"></i>
                            </div>
                        </div>
                        <input wire:model='name' required value="{{ old('name') }}" id="name" name="name" type="text"
                            class="form-control @error('name')is-invalid @enderror">
                    </div>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-block btn-success" type="button" wire:click="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
