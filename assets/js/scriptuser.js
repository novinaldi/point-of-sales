function tampildatauser() {
    table = $('.datauser').DataTable({
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
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
        }
        ],

    });
}
window.addEventListener('load', function () {
    tampildatauser();
});


$(document).on('click', '.tambahdatauser', function (e) {
    $.ajax({
        url: './formtambahdata',
        success: function (x) {
            $('.viewform').fadeIn();
            $('.viewform').html(x);
            $('#modaltambahdata').on('shown.bs.modal', function (e) {
                $('.iduser').focus();
            })
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
                tampildatauser();
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
                tampildatauser();
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

function edituser(id) {
    $.ajax({
        url: './formedit',
        type: 'post',
        data: {
            id: id
        },
        cache: false,
        success: function (x) {
            $('.viewform').fadeIn();
            $('.viewform').html(x);
            $('#modaleditdata').on('shown.bs.modal', function (e) {
                $('.namauser').focus();
            })
            $('#modaleditdata').modal('show');
        }
    });
}

function hapususer(id) {
    Swal.fire({
        title: 'Hapus User',
        text: "Yakin di hapus",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus !',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "./hapusdata",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (response) {
                    if (response.sukses) {
                        tampildatauser();
                        $.toast({
                            heading: 'User Berhasil di Hapus',
                            text: response.sukses,
                            icon: 'success',
                            loader: true,        // Change it to false to disable loader
                            loaderBg: '#9EC600'  // To change the background
                        })
                    }
                },
                error: function (e) {
                    Swal.fire('error', 'Maaf data tidak bisa di eksekusi', 'error');
                }
            });
        }
    })
}

function resetpass(id) {
    Swal.fire({
        title: 'Reset Password',
        text: "Yakin User ini Passwordnya di Reset ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Reset !',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "./resetpassword",
                data: {
                    id: id
                },
                success: function (response) {
                    tampildatauser();

                    $('.viewform').fadeIn();
                    $('.viewform').html(response);
                    $('#modalresetpassword').modal('show');
                },
                error: function (e) {
                    Swal.fire('error', 'Maaf data tidak bisa di eksekusi', 'error');
                }
            });
        }
    })
}