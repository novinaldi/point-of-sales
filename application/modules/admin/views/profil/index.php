<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Update Your Profile
                </h6>
            </div>
            <div class="card-body">
                <?= form_open_multipart('admin/profil/update', ['class' => 'formganti']) ?>
                <?= $this->session->flashdata('pesan'); ?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">ID User</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="iduser" id="iduser" readonly
                            value="<?= $iduser; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama User</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="namauser" id="namauser" value="<?= $namauser; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Ganti Foto</label>
                    <div class="col-sm-4">
                        <input type="file" name="uploadfoto" accept=".jpg,.jpeg,.png">
                    </div>
                    <div class="col-sm-4">
                        <img src="<?= base_url($foto) ?>" width="50%" class="img-thumbnail">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Level</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="level" id="level" readonly value="<?= $level; ?>"
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-fw fa-save"></i> Simpan
                        </button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>