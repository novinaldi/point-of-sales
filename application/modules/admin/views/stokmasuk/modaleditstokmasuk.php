<div class="modal fade bd-example-modal-lg" id="modaledit" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exampleModalLabel">Update Log Stok Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/stok/updatestokmasuk', ['class' => 'form']) ?>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kode Produk</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="kode" id="kode" value="<?= $kode; ?>" readonly>
                        <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Produk</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jumlah Masuk</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="jml" id="jml" value="<?= $jml; ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnsimpan">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
$(document).on('submit', '.form', function(e) {

    $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        cache: false,
        beforeSend: function() {
            $('.btnsimpan').attr('disabled', 'disabled');
            $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i> Sedang di Proses');
        },
        success: function(response) {
            if (response.sukses) {
                $('#modaledit').modal('hide');
                $.toast({
                    heading: 'Alhamdulillah',
                    text: response.sukses,
                    showHideTransition: 'fade',
                    icon: 'error',
                    bgColor: '#03bd1f',
                    textColor: 'white',
                    position: 'top-center'
                });
                tampidatastokmasuk();
            }
        }
    });

    return false;
});
</script>