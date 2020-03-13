<div class="modal fade bd-example-modal-lg" id="modaltambahdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('admin/satuan/simpandata', array('class' => 'formtambah')) ?>
            <div class="modal-body">
                <div class="pesan" style="display: none;"></div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Satuan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="namasatuan" id="namasatuan">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jumlah Per-Satuan</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="jml" id="jml" value="1">
                        <p class="text-left mt-2">
                            <span class="badge badge-info"><i class="fa fa-fw fa-info"></i> Isikan Jumlah <i>Default
                                    Quantity</i> Kegunaannya untuk transaksi</span>
                        </p>
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