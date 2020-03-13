<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Silahkan Ganti Password Anda
                </h6>
            </div>
            <div class="card-body">
                <?= form_open('admin/gantipassword/updatepass', ['class' => 'formganti']) ?>
                <div class="pesan" style="display: none;"></div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password Lama</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="passlama" id="passlama" autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password Baru</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="passbaru" id="passbaru">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Ulangi Password Baru</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="ulangi" id="ulangi">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success btnsimpan">
                            Update Password`
                        </button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<script>
$(document).on('submit', '.formganti', function(e) {
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

            if (response.error) {
                $('.pesan').fadeIn();
                $('.pesan').html(response.error);
                setTimeout(function() {
                    $('.pesan').fadeOut();
                }, 2000);
            }
            if (response.sukses) {
                Swal.fire({
                    title: response.sukses,
                    html: 'Silahkan tunggu <b></b> milliseconds.',
                    timer: 1000,
                    timerProgressBar: true,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                            Swal.getContent().querySelector('b')
                                .textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    onClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.timer
                    ) {
                        window.location.href = ("<?= site_url('login/keluar') ?>");
                    }
                })
            }
        },
        complete: function() {
            $('.btnsimpan').removeAttr('disabled');
            $('.btnsimpan').html('Update Password');
        }
    });

    return false;
});
</script>