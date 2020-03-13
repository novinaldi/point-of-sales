$(document).ready(function (e) {
    tampildata();
    $('.btntambah').click(function () {
        $.ajax({
            url: './formtambahdata',
            success: function (x) {
                $('.viewform').fadeIn();
                $('.viewform').html(x);
                $('#modaltambahdata').on('shown.bs.modal', function (e) {
                    $('#iduser').focus();
                })
                $('#modaltambahdata').modal('show');
            }
        });
    });
});
function tampildata() {
    table = $('.datauser').DataTable({
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

function hapus(id) {
    Swal.fire({
        title: 'Hapus User',
        text: "Yakin Menghapus User ini ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "./hapus",
                data: "&id=" + id,
                dataType: "json",
                success: function (response) {
                    if (response.sukses) {
                        tampildata();
                        Swal.fire('Berhasil', response.sukses, 'success');
                    }
                }
            });
        }
    })
}

function resetpass(id) {
    Swal.fire({
        title: 'Reset Password',
        text: "Reset Password untuk id ini ?",
        icon: 'warning',
        showClass: {
            popup: 'animated fadeInDown faster'
        },
        hideClass: {
            popup: 'animated fadeOutUp faster'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "./resetpassword",
                data: "&id=" + id,
                dataType: "json",
                success: function (response) {
                    if (response.modalreset) {
                        $('.viewform').fadeIn();
                        $('.viewform').html(response.modalreset);
                        $('#modalresetpass').modal('show');
                        // alert(response.user);
                    }
                }
            });
        }
    })
}

