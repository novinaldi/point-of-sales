<style>
label {
    font-weight: bold;
}
</style>
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
                        onclick="window.location.href=('<?= site_url('admin/pembelian/data') ?>')">
                        <i class="fa fa-fw fa-luggage-cart"></i> Lihat Data Pembelian
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <?= form_open('admin/pembelian/simpanfakturpembelian', ['class' => 'formpembelian']) ?>
                <div class="pesan" style="display: none;"></div>
                <div class="row">
                    <div class="col col-md-4">
                        <label>Input Faktur</label>
                        <input type="text" name="nota" id="nota" class="form-control form-control-sm" autofocus> </div>
                    <div class="col col-md-4">
                        <label>Tgl.Faktur</label>
                        <input type="date" name="tgl" id="tgl" class="form-control form-control-sm">
                    </div>
                    <div class="col col-md-4">
                        <label>Supplier</label>
                        <select name="sup" class="form-control form-control-sm">
                            <?php
                            foreach ($datasupplier->result_array() as $s) {
                                echo '<option value="' . $s['supid'] . '">' . $s['supnm'] . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <hr class="sidebar-divider">

                <div class="row">
                    <div class="col col-md-12">
                        <p class="text-left">
                            <button type="submit" class="btn btn-success btnadd">
                                <i class="fa fa-fw fa-plus"></i> Add
                            </button>&nbsp;
                            <button type="button" class="btn btn-info" onclick="window.location.reload();">
                                <i class="fa fa-fw fa-retweet"></i> Transaksi Baru
                            </button>
                            <button type="button" class="btn btn-danger btnbatal" style="display: none;"
                                onclick="bataltransaksi();">
                                <i class="fa fa-fw fa-ban"></i> Batalkan Transaksi ?
                            </button>
                        </p>
                    </div>
                </div>
                <?= form_close() ?>
                <div class="row viewdetailpembelian" style="display: none">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// function test() {
//     if (event.keyCode == 116) {
//         event.preventDefault();
//         alert('Anda menekan tombol F3');
//     }
// }
$(document).ready(function(e) {
    setTimeout(function() {
        $('.pesan').fadeOut();
    }, 2000);
});
$(document).on('submit', '.formpembelian', function(e) {
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
            if (response.suksespembelian) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: response.suksespembelian,
                    showConfirmButton: true
                }).then((result) => {
                    $('.btnadd').attr('disabled', 'disabled');
                    $('#kode').focus();
                });
                $('input').attr('disabled', 'disabled');
                $('select').attr('disabled', 'disabled');

                tampilforminputdetail();
            }
        },
        complete: function() {
            $('.btnsimpan').removeAttr('disabled');
            $('.btnsimpan').html('Simpan');
        }
    });

    return false;
});

function tampilforminputdetail() {
    let nota = $('#nota').val();
    $.ajax({
        type: "post",
        url: './formdetailpembelian',
        data: "&nota=" + nota,
        success: function(response) {
            $('.viewdetailpembelian').fadeIn();
            $('.viewdetailpembelian').html(response);
            $('#kode').focus();
            $('.btnbatal').fadeIn();
        }
    });
}

function bataltransaksi() {
    let nota = $('#nota').val();
    Swal.fire({
        title: 'Batal Transaksi',
        text: "Yakin Batal Transaksi ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: './bataltransaksi',
                data: "&nota=" + nota,
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil !',
                            text: response.sukses
                        }).then((result) => {
                            window.location.reload();
                        });
                    }
                }
            });
        }
    })

}
</script>