<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-outline-warning"
                        onclick="window.location.href=('<?= site_url('admin/laporan/index') ?>')">
                        <i class="fa fa-fw fa-hand-point-left"></i> Kembali
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <?= form_open('admin/laporan/laporanpendapatan', ['class' => 'lappendapatan']) ?>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="tahun">Inputkan Tahun</label>
                                    <input type="text" name="tahun" id="tahun" class="form-control" autofocus
                                        onkeypress="return hanyaAngka(event)" maxlength="4">
                                    <script>
                                    function hanyaAngka(evt) {
                                        var charCode = (evt.which) ? evt.which : event.keyCode
                                        if (charCode > 31 && (charCode < 48 || charCode > 57))

                                            return false;
                                        return true;
                                    }
                                    </script>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btncetak btn-block">
                                        <i class="fa fa-fw fa-print"></i> Cetak
                                    </button>
                                </div>
                            </div>

                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).on('submit', '.lappendapatan', function(e) {
    $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
            $('.btncetak').attr('disabled', 'disabled');
            $('.btncetak').html('<i class="fa fa-fw fa-spin fa-spinner"></i> Tunggu');
        },
        complete: function() {
            $('.btncetak').removeAttr('disabled');
            $('.btncetak').html('Cetak');
        },
        success: function(response) {
            if (response.error) {
                $.toast({
                    heading: 'Error',
                    text: response.error,
                    hideAfter: 1000,
                    icon: 'error',
                    position: 'top-center'
                });
            }
            if (response.sukses) {
                cetak(response.sukses);
            }
        }
    });
    return false;
});

var newwindow;

function cetak(url) {
    newwindow = window.open(url, 'name', 'height=500,width=520,scrollbars=yes');
    if (window.focus) {
        newwindow.focus()
    }
    return false;
}
</script>