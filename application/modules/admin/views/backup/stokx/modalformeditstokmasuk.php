<div class="modal fade bd-example-modal-lg" id="modaleditstokmasuk" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Edit Stok Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('admin/stok/updatedatastokmasuk', array('class' => 'formedit')) ?>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="modal-body">
                <div class="alert alert-info">
                    Silahkan Update Stok Masuk
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jumlah Stok Masuk</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="jmlmasuk" value="<?php echo $jmlmasuk ?>">
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
<script>
$(document).on('submit', '.formedit', function(e) {
    $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
            $('.btnsimpan').attr('disabled', 'disabled');
            $('.btnsimpan').html('<i class="fa fa-fw fa-spin fa-spinner"></i>');
        },
        complete: function() {
            $('.btnsimpan').removeAttr('disabled');
            $('.btnsimpan').html('Simpan');
        },
        success: function(response) {
            if (response.sukses) {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: response.sukses,
                    showConfirmButton: true

                }).then((result) => {
                    if (result.value) {
                        window.location.reload();
                    }
                })
            }
        }
    });
    return false;
});
</script>