<div class="modal fade bd-example-modal-lg" id="modaltambahdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('admin/supplier/simpandata', array('class' => 'formtambah')) ?>
            <div class="modal-body">
                <div class="pesan" style="display: none;"></div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Supplier</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="namasupplier" id="namasupplier">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="alamat" id="alamat">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Telp/No.HP</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="telp" id="telp">
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