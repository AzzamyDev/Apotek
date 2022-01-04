<div class="modal-dialog">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h5 class="modal-title text-white">{{ $user_id != null ? 'Edit Data' : 'Form' }} Karyawan </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <form autocomplete="off">
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-white">Nama Lengkap</label>
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
                <div class="form-group">
                    <label class="text-white">Pilih Jabatan</label>
                    <select wire:model.defer='jabatan' id="jabatan" name="jabatan" class="form-control selectric">
                        <option value="">Pilih Jabatan</option>
                        @foreach ($jabatans as $item)
                            <option {{ $jabatan == $item->nama ? 'selected' : '' }} value="{{ $item->nama }}">
                                {{ $item->nama }}</option>
                        @endforeach
                    </select>
                    @error('jabatan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="text-white">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        <input wire:model='username' required value="{{ old('username') }}" id="username"
                            name="username" type="username" class="form-control @error('username')is-invalid @enderror">
                    </div>
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="text-white">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        <input wire:model='password' name="password"
                            type="{{ $this->password != null ? 'text' : 'password' }}"
                            class="form-control pwstrength @error('password')is-invalid @enderror"
                            data-indicator="pwindicator">
                    </div>
                    @error('password')
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
