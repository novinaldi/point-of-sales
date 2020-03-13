$(document).ready(function () {
    tampilstokproduk();
});
$(document).bind('keydown', 'ctrl+1', function () {
    $('#kode').focus();
});

function cariproduk() {
    $.ajax({
        url: './cariproduk',
        success: function (response) {
            $('.viewform').fadeIn();
            $('.viewform').html(response);
            $('#modalcariproduk').modal('show');
        }
    });
}
$(document).on('click', '.btncariproduk', function (e) {
    cariproduk();
});

function pilih(id) {
    $.ajax({
        type: "post",
        url: './pilihdataproduk',
        data: "&idproduk=" + id,
        dataType: "json",
        success: function (response) {
            $('#idproduk').val(response.idproduk);
            $('#namaproduk').val(response.namaproduk);
            $('#modalcariproduk').modal('hide');
            $('input[name="kode"]').focus();
        }
    });
}

// $(document).on('keypress', '#kode', function (e) {
//     if (e.which == 13) {
//         let kode = $('#kode').val();
//         let qty = $('#qty').val();
//         let idproduk = $('#idproduk').val();
//         if (kode == '') {
//             return false;
//         } else {
//             $.ajax({
//                 type: "post",
//                 url: './cekkode',
//                 data: "&kode=" + kode + "&qty=" + qty + "&idproduk=" + idproduk,
//                 dataType: "json",
//                 success: function (data) {
//                     if (data.error) {
//                         Swal.fire('Error !', data.error, 'error');
//                         $('#kode').focus();
//                     }
//                     if (data.sukses) {
//                         window.location.reload();
//                     }
//                 }
//             });
//         }
//     }
// });

$(document).on('keypress', '#qty', function (e) {
    if (e.which == 13) {
        $('#kode').focus();
    }
});

function tampilstokproduk() {
    table = $('.datastokproduk').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": './ambildatastok',
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

$(document).on('submit', '.formsimpan', function (e) {
    $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function () {
            $('.btnsimpan').attr('disabled', 'disabled');
            $('.btnsimpan').html('<i class="fa fa-fw fa-spin fa-spinner"></i>');
        },
        complete: function () {
            $('.btnsimpan').removeAttr('disabled');
            $('.btnsimpan').html('Simpan');
        },
        success: function (response) {
            if (response.error) {
                Swal.fire('Perhatian', response.error, 'error');
            }
            if (response.sukses) {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: response.sukses,
                    showConfirmButton: true

                }).then((result) => {
                    if (result.value) {
                        window.location.reload();
                    }
                })
            }
        }
    });
    return false;
});

function lihatdatastokmasuk() {
    window.location.href = ('./datastokmasuk');
}
function kembalikeinput() {
    window.location.href = ('./input');
}