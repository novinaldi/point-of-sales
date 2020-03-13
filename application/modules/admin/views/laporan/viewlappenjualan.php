<link href="<?= base_url('assets/') ?>vendor/select2/select2.min.css" rel="stylesheet" />
<script src="<?= base_url('assets/') ?>vendor/select2/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#kat').select2();
    $('#sat').select2();
});
</script>

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
                                <?= form_open('admin/laporan/laporanpenjualan', ['class' => 'lappenjualan']) ?>
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
                                        <label for="tglawal">Pilih Kategori</label>
                                        <select class="form-control" name="kat" id="kat">
                                            <option value="" selected>=Semua=</option>
                                            <?php
                                            foreach ($datakategori->result_array() as $r) {
                                                echo '<option value="' . $r['katid'] . '">' . $r['katnama'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info btnlappenjualan">
                                            Cetak Laporan Penjualan
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
$(document).on('submit', '.lappenjualan', function(e) {
    $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
            $('.btnlappenjualan').attr('disabled', 'disabled');
            $('.btnlappenjualan').html('<i class="fa fa-fw fa-spin fa-spinner"></i> Tunggu');
        },
        complete: function() {
            $('.btnlappenjualan').removeAttr('disabled');
            $('.btnlappenjualan').html('Cetak Laporan Penjualan');
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