<div class="modal-dialog">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h5 class="modal-title text-white">{{ $dokter_id != null ? 'Edit Data' : 'Form' }} Dokter </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <form autocomplete="off">
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-white">Nama Dokter</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-user"></i>
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
                    <label class="text-white">Nomer Telpon</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-phone"></i>
                            </div>
                        </div>
                        <input wire:model='telepon' required value="{{ old('telepon') }}" id="telepon" name="telepon"
                            type="number" class="form-control @error('telepon')is-invalid @enderror">
                    </div>
                    @error('telepon')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @if ($dokter_id != null)
                    <div class="form-group">
                        <div class="control-label text-white">Status</div>
                        <label class="custom-switch mt-2">
                            <input before type="checkbox" wire:model="status" name="custom-switch-checkbox"
                                class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description text-white">Ubah status dokter</span>
                        </label>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn-block btn-success" type="button" wire:click="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
