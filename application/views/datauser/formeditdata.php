<div class="modal fade bd-example-modal-lg" id="modaleditdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('superadmin/datauser/updatedata', array('class' => 'formedit')) ?>
            <div class="modal-body">
                <div class="pesan" style="display: none;"></div>
                <input type="hidden" name="id" value="<?= $id; ?>">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">ID User</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control iduser" name="iduser" id="iduser" value="<?= $userid ?>"
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Lengkap User</label>
                    <div class="col-sm-9">
                        <input type="text" name="namauser" id="namauser" class="form-control" value="<?= $usernama ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pilih Toko</label>
                    <div class="col-sm-9">
                        <select name="toko" id="toko" class="form-control">
                            <option value="" selected="selected">-Wajib Pilih-</option>
                            <?php
                            foreach ($datatoko as $toko) :
                                if ($toko->tokoid == $usertokoid) {
                                    echo "<option selected value=\"$toko->tokoid\">$toko->tokonama</option>";
                                } else {
                                    echo "<option value=\"$toko->tokoid\">$toko->tokonama</option>";
                                }
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pilih Level</label>
                    <div class="col-sm-9">
                        <select name="level" id="level" class="form-control">
                            <option value="" selected="selected">-Wajib Pilih-</option>
                            <?php
                            foreach ($datalevel as $level) :
                                if ($level->levelid == $userlevelid) {
                                    echo "<option selected value=\"$level->levelid\">$level->levelnama</option>";
                                } else {
                                    echo "<option value=\"$level->levelid\">$level->levelnama</option>";
                                }
                            endforeach;
                            ?>
                        </select>
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