<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <button class="btn btn-warning"
                        onclick="window.location.href=('<?= site_url('admin/transaksi/index') ?>')">
                        <i class="fa fa-fw fa-hand-point-left"></i> Kembali
                    </button>
                    <button class="btn btn-primary"
                        onclick="window.location.href=('<?= site_url('admin/penjualan/data') ?>')">
                        <i class="fa fa-fw fa-hand-point-right"></i> Lihat Data Penjualan
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="kode">Kode Barcode</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-lg" name="kode" id="kode"
                                    placeholder="Input Barcode">
                                <div class="input-group-append">
                                    <button class="btn btn-info btncariproduk" type="button">
                                        <i class="fa fa-fw fa-search"></i>
                                    </button>
                                    <div class="viewcariproduk" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="qty">Qty</label>
                        <input type="number" name="qty" id="qty" class="form-control" value="1"
                            style="text-align: center;" onkeypress="pindah(event);">
                    </div>
                    <div class="col-sm-4">
                        <label for="nota">NoFaktur</label>
                        <h4 class="font-weight-bold text-dark"><?= $nota; ?></h4>
                        <input type="hidden" name="nota" id="nota" value="<?= $nota; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col col-sm-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success">
                                    Detail Data
                                </h6>
                                <p class="text-right">
                                    <button type="button" class="btn btn-danger btnbataltransaksi"
                                        style="display: none;" onclick="batalkan('<?= $nota; ?>')">
                                        <i class="fa fa-fw fa-ban"></i> Batalkan Transaksi
                                    </button>
                                    <button type="button" class="btn btn-success btnselesai" style="display: none;"
                                        onclick="selesai('<?= $nota; ?>')">
                                        <i class="fa fa-fw fa-hand-point-right"></i> Selesai Transaksi
                                    </button>
                                </p>
                            </div>
                            <div class="card-body viewdetaildata" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="viewcariproduk" style="display: none;"></div>
<div class="viewpembayaran" style="display: none;"></div>
<script>
$(document).ready(function() {
    $('#kode').focus();
    tampildetaildata();
    $('.btncariproduk').click(function() {
        $.ajax({
            url: "<?= site_url('admin/penjualan/cariproduk') ?>",
            success: function(response) {
                $('.viewcariproduk').fadeIn();
                $('.viewcariproduk').html(response);
                $('#modalcariproduk').modal('show');
            }
        });
    });

    $('#kode').keypress(function(e) {
        let kode = $(this).val();
        let nota = $('#nota').val();
        let qty = $('#qty').val();
        if (e.which == 13) {
            $.ajax({
                url: "<?= site_url('admin/penjualan/simpantemp') ?>",
                type: "post",
                dataType: "json",
                data: "&kode=" + kode + "&nota=" + nota + "&qty=" + qty,
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Error', response.error, 'error');
                    }

                    if (response.sukses) {
                        tampildetaildata();
                        $('.btnselesai').fadeIn();
                        $('.btnbataltransaksi').fadeIn();
                        $('#kode').val('');
                        $('#qty ').val(1);
                        $('#kode').focus();
                    }
                }
            });

        }
    });
});

function tampildetaildata() {
    let nota = $('#nota').val();
    $.ajax({
        type: "post",
        url: "<?= site_url('admin/penjualan/tampildetaildata') ?>",
        data: "&nota=" + nota,
        success: function(response) {

            $('.viewdetaildata').fadeIn();
            $('.viewdetaildata').html(response);
        }
    });
}

function pindah(e) {
    if (e.keyCode == 13) {
        $('#kode').focus();
    }
}

function batalkan(nota) {
    Swal.fire({
        title: 'Batalkan Transaksi Penjualan',
        text: "Yakin ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Batalkan !'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "<?= site_url('admin/penjualan/batalkan') ?>",
                data: "&nota=" + nota,
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        window.location.reload();
                    }
                }
            });
        }
    })
}

function selesai(nota) {
    let total = $('#total').val();
    $.ajax({
        type: "post",
        url: "<?= site_url('admin/penjualan/simpantransaksi') ?>",
        data: "&nota=" + nota + "&total=" + total,
        cache: false,
        success: function(response) {
            if (response) {
                $('.viewpembayaran').fadeIn();
                $('.viewpembayaran').html(response);
                $('#jmlbayar').focus();
                $('#modalpembayaran').modal('show');
            }
        }
    });
}
</script>