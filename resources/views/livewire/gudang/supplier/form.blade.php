<div class="modal-dialog">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h5 class="modal-title text-white">{{ $supplier_id != null ? 'Edit Data' : 'Form' }} Supplier </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <form autocomplete="off">
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-white">Nama Supplier</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-truck"></i>
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
                    <label class="text-white">Nomer Telepon</label>
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
                <div class="form-group">
                    <label class="text-white">Alamat</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                        <input wire:model='alamat' required value="{{ old('alamat') }}" id="alamat" name="alamat"
                            type="textarea" class="form-control @error('alamat')is-invalid @enderror">
                    </div>
                    @error('alamat')
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
