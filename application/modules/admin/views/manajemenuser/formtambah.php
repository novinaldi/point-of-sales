<script src="<?php echo base_url('assets/js/jquery.form.js') ?>"></script>
<script>
// $(document).on('keydown', 'body', function() {
// if (event.keyCode == 116) {
//     event.preventDefault();
//     alert('adfsdf');
// }
// });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-outline-warning"
                        onclick="window.location.href=('<?= site_url('admin/manajemenuser/index') ?>')">
                        <i class="fa fa-fw fa-hand-point-left"></i> Kembali
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <?php echo form_open_multipart('admin/manajemenuser/simpandata', array('class' => 'formtambah')) ?>
                <?= $this->session->flashdata('pesan'); ?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">ID User</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="iduser" id="iduser">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama User</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="namauser" id="namauser">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Level</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="level">
                            <option value="2">Kasir</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Upload Foto (Jika Ada)</label>
                    <div class="col-sm-6">
                        <input type="file" name="upload" accept=".jpg,.png,.jpeg">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-success btn-btn-block">
                            Simpan
                        </button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>