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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <?= form_open('admin/laporan/laporanpembelian', ['class' => 'lappembelian']) ?>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="tglawal">Tgl.Awal</label>
                                        <input type="date" name="tglawal" id="tglawal" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="tglawal">Tgl.Akhir</label>
                                        <input type="date" name="tglakhir" id="tglakhir" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info btnlappembelian">
                                            Cetak Laporan Pembelian
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
</div>
<script>
$(document).on('submit', '.lappembelian', function(e) {
    $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
            $('.btnlappembelian').attr('disabled', 'disabled');
            $('.btnlappembelian').html('<i class="fa fa-fw fa-spin fa-spinner"></i> Tunggu');
        },
        complete: function() {
            $('.btnlappembelian').removeAttr('disabled');
            $('.btnlappembelian').html('Cetak Laporan Pembelian');
        },
        success: function(response) {
            if (response.error) {
                Swal.fire('Perhatian', response.error, 'error');
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