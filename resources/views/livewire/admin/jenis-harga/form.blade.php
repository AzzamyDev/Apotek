<div class="modal-dialog">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h5 class="modal-title text-white">{{ $jenis_id != null ? 'Edit Data' : 'Form' }} Jenis Harga </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <form autocomplete="off">
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-white">Nama Jenis Harga</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-funnel-dollar"></i>
                            </div>
                        </div>
                        <input wire:model='name' required value="{{ old('name') }}" id="name" name="name" type="text"
                            class="form-control @error('name')is-invalid @enderror">
                    </div>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="text-white">Persentase</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-percent"></i>
                            </div>
                        </div>
                        <input wire:model='persentase' required value="{{ old('persentase') }}" id="persentase"
                            name="persentase" type="number"
                            class="form-control @error('persentase')is-invalid @enderror">
                    </div>
                    @error('persentase')
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
