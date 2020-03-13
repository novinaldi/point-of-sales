<div class="modal fade bd-example-modal-lg" id="modalpembayaran" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/penjualan/updatepenjualan', ['class' => 'formpembayaran']) ?>
            <div class="modal-body">
                <table class="table table-striped" id="" width="100%" cellspacing="0">
                    <tr>
                        <td>No.Faktur Penjualan</td>
                        <td>:</td>
                        <td><?= $nota; ?> <input type="hidden" name="nota" id="nota" value="<?= $nota; ?>"></td>
                    </tr>
                    <tr>
                        <td>Total Bayar</td>
                        <td>:</td>
                        <td><?= 'Rp  ' . number_format($total, 0, ",", "."); ?>
                            <input type="hidden" name="total" id="total" value="<?= $total; ?>"> </td>
                    </tr>
                    <tr>
                        <td>Jumlah Bayar</td>
                        <td>:</td>
                        <td>
                            <input type="number" style="text-align: center;" class="form-control" name="jmlbayar"
                                id="jmlbayar" onkeyup="hitung();">
                        </td>
                    </tr>
                    <tr>
                        <td>Sisa</td>
                        <td>:</td>
                        <td>
                            <input type="text" class="form-control" name="sisax" id="sisax" readonly>
                            <input type="hidden" class="form-control" name="sisa" id="sisa">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
$(document).on('submit', '.formpembayaran', function(e) {
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
                window.location.reload();
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

function hitung() {
    let jmlbayar = $('#jmlbayar').val();
    let total = $('#total').val();
    let sisaxx;
    sisaxx = parseInt(jmlbayar) - parseInt(total);
    // yy = formatRupiah(sisaxx, 'Rp. ');
    $('#sisax').val(sisaxx);
}
// var rupiah = document.getElementById('sisax');
// rupiah.addEventListener('keyup', function(e) {
//     // tambahkan 'Rp.' pada saat form di ketik
//     // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka

//     rupiah.value = formatRupiah(this.value, 'Rp. ');

//     var ganti = rupiah.value.replace(/[^,\d]/g, '').toString();
//     document.getElementById('sisa').value = ganti;
// });

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
</script>