$(document).ready(function (e) {
    tampildata();
});
function tampildata() {
    table = $('.dataproduk').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": './ambildata',
            "type": "POST"
        },


        "columnDefs": [{
            "targets": [0],
            "orderable": false,
            "width": 5
        }, {
            "targets": [5],
            "orderable": false,
            "className": "text-right"
        }

        ],

    });
}
$(document).on('click', '.btntambah', function (e) {
    $.ajax({
        url: './formtambahdata',
        success: function (x) {
            $('.viewform').fadeIn();
            $('.viewform').html(x);
            $('#modaltambahdata').on('shown.bs.modal', function (e) {
                $('#kode').focus();
            });
            $('#modaltambahdata').modal('show');
        }
    });
});

$(document).on('submit', '.formtambah', function (e) {

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
                $('.pesan').fadeIn();
                $('.pesan').html(response.error);
            }

            if (response.berhasil) {
                tampildata();
                $('#modaltambahdata').modal('hide');
                Swal.fire('Berhasil', response.berhasil, 'success');
            }
        },
        complete: function () {
            $('.btnsimpan').removeAttr('disabled');
            $('.btnsimpan').html('Simpan');
        }
    });

    return false;
});

function hapus(id) {
    Swal.fire({
        title: 'Hapus Data Produk',
        text: "Yakin produk ini dihapus ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "./hapusdata",
                data: "&id=" + id,
                dataType: "json",
                success: function (response) {
                    if (response.sukses) {
                        tampildata();
                        Swal.fire('Berhasil', response.sukses, 'success');
                    }
                },
                error: function (e) {
                    Swal.fire('Error', 'Maaf data tidak dapat dihapus, kemungkinan data sedang dipakai oleh transaksi', 'error');
                }
            });
        }
    })
}

function edit(id) {
    $.ajax({
        type: "post",
        url: "./formedit",
        data: "&id=" + id,
        cache: false,
        success: function (response) {
            $('.viewform').fadeIn();
            $('.viewform').html(response);
            $('#modaleditdata').modal('show');
        }
    });
}

$(document).on('submit', '.formedit', function (e) {

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
                $('.pesan').fadeIn();
                $('.pesan').html(response.error);
            }

            if (response.berhasil) {
                tampildata();
                $('#modaleditdata').modal('hide');
                Swal.fire('Berhasil', response.berhasil, 'success');
            }
        },
        complete: function () {
            $('.btnsimpan').removeAttr('disabled');
            $('.btnsimpan').html('Update');
        }
    });

    return false;
});