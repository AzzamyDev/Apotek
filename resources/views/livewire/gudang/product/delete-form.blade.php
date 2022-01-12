<div class="modal-dialog modal-dialog-centered modal-dialog-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalTitle">Hapus Master Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Yakin mau hapus {{ $nama_barang }} ?
        </div>
        <div class="modal-footer">
            <button wire:click="resetDelete" type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            <button wire:click='destroy' type="button" class="btn btn-primary">Iya</button>
        </div>
    </div>
</div>
