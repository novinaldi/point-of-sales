<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <button class="btn btn-warning"
                        onclick="window.location.href=('<?= site_url('admin/pembelian/data') ?>')">
                        <i class="fa fa-fw fa-hand-point-left"></i> Kembali
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <div class="pesan" style="display: none;"></div>
                <div class="row">
                    <div class="col col-md-4">
                        <label>Faktur</label>
                        <input type="text" name="nota" id="nota" value="<?= $nota; ?>"
                            class="form-control form-control-sm" readonly>
                    </div>
                    <div class="col col-md-4">
                        <label>Tgl.Faktur</label>
                        <input type="date" name="tgl" id="tgl" class="form-control form-control-sm" value="<?= $tgl; ?>"
                            readonly>
                    </div>
                    <div class="col col-md-4">
                        <label>Supplier</label>
                        <select name="sup" class="form-control form-control-sm">
                            <?php
                            foreach ($datasupplier->result_array() as $s) {
                                if ($idsup == $s['supid']) {
                                    echo '<option value="' . $s['supid'] . '" selected>' . $s['supnm'] . '</option>';
                                } else {
                                    echo '<option value="' . $s['supid'] . '">' . $s['supnm'] . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <div class="alert alert-info">Silahkan Tambahkan Produk, jika ada kekurangan !!!</div>

                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success">
                                    Input Kode Barcode, Qty dan Harga Pembelian Produk
                                </h6>
                            </div>
                            <div class="card-body">
                                <?= form_open('admin/pembelian/simpandetailpembelian', ['class' => 'formdetailbeli']) ?>
                                <input type="hidden" name="nota" id="nota" value="<?= $nota; ?>">
                                <div class="form-group msg" style="display: none; font-size:8pt;">
                                </div>
                                <div class="form-group">
                                    <label>Kode Barcode</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-lg" name="kode" id="kode"
                                            placeholder="Input Barcode" autofocus>
                                        <div class="input-group-append">
                                            <button class="btn btn-info btncariproduk" type="button">
                                                <i class="fa fa-fw fa-search"></i>
                                            </button>
                                            <div class="viewcariproduk" style="display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input type="number" name="qty" id="qty" class="form-control form-control-sm"
                                        value="1" style="text-align: center;">
                                </div>
                                <div class="form-group">
                                    <label>Harga Beli (Rp)</label>
                                    <input type="text" name="hargax" id="hargax"
                                        class="form-control form-control-sm text-primary"
                                        style="font-weight: bold;text-align: right;" value="0">
                                    <input type="hidden" name="harga" id="harga" class="form-control form-control-sm">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-success btnsimpan">
                                        Simpan Detail
                                    </button>
                                </div>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-8">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success">
                                    Daftar Pembelian Produk Berdasarkan Faktur
                                </h6>
                            </div>
                            <div class="card-body tampildetailpembelian">
                                <div class="row">
                                    <div class="pesandetail table-responsive" style="display: none;"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var rupiah = document.getElementById('hargax');
rupiah.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka

    rupiah.value = formatRupiah(this.value, 'Rp. ');

    var ganti = rupiah.value.replace(/[^,\d]/g, '').toString();
    document.getElementById('harga').value = ganti;
});

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
}
$(document).on('click', '.btncariproduk', function(e) {
    $.ajax({
        url: "<?= site_url('admin/pembelian/cariprodukx') ?>",
        success: function(response) {
            $('.viewcariproduk').fadeIn();
            $('.viewcariproduk').html(response);
            $('#modalcariproduk').modal('show');
        }
    });
});

function tampildetailpembelian() {
    let nota = $('#nota').val();
    $.ajax({
        type: "post",
        url: "<?= site_url('admin/pembelian/tampildetailpembelian') ?>",
        data: "&nota=" + nota,
        success: function(response) {
            $('.tampildetailpembelian').html(response);
        }
    });
}
$(document).ready(function() {
    tampildetailpembelian();
});
$(document).on('submit', '.formdetailbeli', function(e) {
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
                $('.msg').fadeIn();
                $('.msg').html(response.error);
                setTimeout(function() {
                    $('.msg').fadeOut();
                }, 2000);
            }
            if (response.sukses) {
                $('.pesandetail').fadeIn();
                $('.pesandetail').html(response.sukses);
                tampildetailpembelian();
                $('#kode').val('');
                $('#qty').val('1');
                $('#harga').val(0);
                $('#hargax').val(0);
                $('#kode').focus();
            }
            if (response.hargakosong) {
                Swal.fire('Perhatian', response.hargakosong, 'question');
                $('#hargax').focus();
            }
        },
        complete: function() {
            $('.btnsimpan').removeAttr('disabled');
            $('.btnsimpan').html('Simpan Detail');
        }
    });

    return false;
});
</script>