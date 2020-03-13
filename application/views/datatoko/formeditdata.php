<div class="modal fade bd-example-modal-lg" id="modaleditdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Toko</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('superadmin/datatoko/updatedata', array('class' => 'formedit')) ?>
            <div class="modal-body">
                <div class="pesan" style="display: none;"></div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Toko</label>
                    <div class="col-sm-9">
                        <input type="hidden" name="idtoko" id="idtoko" value="<?= $id; ?>">
                        <input type="text" class="form-control namatoko" name="namatoko" id="namatoko"
                            value="<?= $nama; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <textarea name="alamat" id="alamat" class="form-control"><?= $alamat; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No.Telp/HP</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control telp" name="telp" id="telp"
                            placeholder="Silahkan isi No.HP/Telp Dengan Lengkap" value="<?= $telp; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Pemilik Toko</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control namapemilik" name="namapemilik" id="namapemilik"
                            value="<?= $pemilik; ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnsimpan">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>