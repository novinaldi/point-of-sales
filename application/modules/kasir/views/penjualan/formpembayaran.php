<div class="modal fade bd-example-modal-lg" id="modalpembayaran" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('kasir/penjualan/updatepenjualan', ['class' => 'formpembayaran']) ?>
            <div class="modal-body">
                <table class="table table-striped" id="" width="100%" cellspacing="0">
                    <tr>
                        <td>No.Faktur Penjualan</td>
                        <td>:</td>
                        <td><?= $nota; ?> <input type="hidden" name="nota" id="nota" value="<?= $nota; ?>"></td>
                    </tr>
                    <tr>
                        <td>Total Bayar (Rp)</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="totalx" id="totalx" style="background-color:#cfd4d1;"
                                class="form-control-lg" value="<?= number_format($total, 0, ",", ".") ?>" readonly>
                            <input type="hidden" name="totalxx" id="totalxx" value="<?= $total; ?>">
                            <input type="hidden" name="total" id="total" value="<?= $total; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Input Disc (Rp)</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="diskonx" id="diskonx" class="form-control-lg">
                            <input type="hidden" name="diskon" id="diskon" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Jumlah Bayar</td>
                        <td>:</td>
                        <td>
                            <input type="text" style="text-align: left;" class="form-control-lg" name="jmlbayarx"
                                id="jmlbayarx" autocomplete="off">
                            <input type="hidden" name="jmlbayar" id="jmlbayar">
                        </td>
                    </tr>
                    <tr>
                        <td>Sisa</td>
                        <td>:</td>
                        <td>
                            <input type="text" class="form-control-lg" name="sisax" id="sisax" readonly
                                style="background-color: #797d7b;color: white;font-weight: bold;">
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
    pesan = confirm('Yakin dilanjutkan transaksi ?');
    if (pesan) {
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
    } else {
        return false;
    }
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
<script>
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

let totalx = document.querySelector('#totalx');
let totalxx = document.querySelector('#totalxx');
let diskonx = document.querySelector('#diskonx');
let diskon = document.querySelector('#diskon');
let jmlbayarx = document.querySelector('#jmlbayarx');
let jmlbayar = document.querySelector('#jmlbayar');
let sisax = document.querySelector('#sisax');
let sisa = document.querySelector('#sisa');

const dis = () => {
    diskonx.value = formatRupiah(diskonx.value, '');

    let gantidiskon = diskonx.value.replace(/[^,\d]/g, '').toString();
    diskon.value = gantidiskon;

    let totalbaru = parseInt(total.value) - gantidiskon;
    totalxx.value = totalbaru;

    totalx.value = formatRupiah(totalxx.value, '');
}

const bayar = () => {
    jmlbayarx.value = formatRupiah(jmlbayarx.value, '');
    let gantijmlbayar = jmlbayarx.value.replace(/[^,\d]/g, '').toString();
    jmlbayar.value = gantijmlbayar;

    let sisabaru = parseInt(jmlbayar.value) - parseInt(totalxx.value);
    sisax.value = sisabaru
    sisa.value = sisabaru

    // sisax.value = formatRupiah(sisa.value, '');
}



diskonx.addEventListener('keyup', dis);
jmlbayarx.addEventListener('keyup', bayar);
</script>