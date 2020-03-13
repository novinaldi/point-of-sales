<div class="modal fade bd-example-modal-lg" id="modaleditdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('admin/satuan/updatedata', array('class' => 'formedit')) ?>
            <input type="hidden" name="idsatuan" value="<?php echo $idsatuan ?>">
            <div class="modal-body">
                <div class="pesan" style="display: none;"></div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Satuan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="namasatuan" value="<?php echo $namasatuan ?>">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Jumlah Per-Satuan</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="jml" id="jml" value="<?php echo $jml ?>">
                    <p class="text-left mt-2">
                        <span class="badge badge-info"><i class="fa fa-fw fa-info"></i> Isikan Jumlah <i>Default
                                Quantity</i> Kegunaannya untuk transaksi</span>
                    </p>
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