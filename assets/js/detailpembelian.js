var rupiah = document.getElementById('hargax');
rupiah.addEventListener('keyup', function (e) {
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

function tampildetailpembelian() {
    let nota = $('#nota').val();
    $.ajax({
        type: "post",
        url: './tampildetailpembelian',
        data: "&nota=" + nota,
        success: function (response) {
            $('.tampildetailpembelian').html(response);
        }
    });
}
$(document).ready(function () {
    tampildetailpembelian();
});

$(document).on('submit', '.formdetailbeli', function (e) {
    $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        cache: false,
        beforeSend: function () {
            $('.btnsimpan').attr('disabled', 'disabled');
            $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i> Sedang di Proses');
        },
        success: function (response) {

            if (response.error) {
                $('.msg').fadeIn();
                $('.msg').html(response.error);
                setTimeout(function () {
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
        complete: function () {
            $('.btnsimpan').removeAttr('disabled');
            $('.btnsimpan').html('Simpan Detail');
        }
    });

    return false;
});