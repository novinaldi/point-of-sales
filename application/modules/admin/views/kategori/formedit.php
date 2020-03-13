<div class="modal fade bd-example-modal-lg" id="modaleditdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('admin/kategori/updatedata', array('class' => 'formedit')) ?>
            <input type="hidden" name="idkategori" value="<?php echo $idkategori ?>">
            <div class="modal-body">
                <div class="pesan" style="display: none;"></div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Kategori</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="namakategori" value="<?php echo $namakategori ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pilih Keterangan</label>
                    <div class="col-sm-4">
                        <select name="ket" id="ket" class="form-control form-control-sm">
                            <option value="-" <?php if ($ket == '-') echo 'selected' ?>>-</option>
                            <option value="P" <?php if ($ket == 'P') echo 'selected' ?>>Stok Tak Terhitung</option>
                        </select>
                        <p class="mt-2">
                            <span class="badge badge-info">Silahkan Pilih Keterangan Diatas, jika
                                <strong>Kategori</strong> memiliki stok yang tak terhitung</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnsimpan">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>