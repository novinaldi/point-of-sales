$(document).on('submit', '.formlogin', function (e) {
    $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        cache: false,
        beforeSend: function () {
            $('.btnlogin').attr('disabled', 'disabled');
            $('.btnlogin').html('<i class="fa fa-spin fa-spinner"></i> Sedang di Proses');
        },
        complete: function () {
            $('.btnlogin').removeAttr('disabled');
            $('.btnlogin').html('<i class="fa fw fa-sign-in-alt"></i> Login');
        },
        success: function (data) {
            if (data.error) {
                $('.pesan').fadeIn();
                $('.pesan').html(data.error);
            }
            if (data.sukses) {
                let timerInterval
                Swal.fire({
                    title: data.sukses,
                    html: 'Silahkan tunggu <b></b> milliseconds.',
                    timer: 500,
                    timerProgressBar: true,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                            Swal.getContent().querySelector('b')
                                .textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    onClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.timer
                    ) {
                        if (data.idlevel == 3) {
                            window.location.href = ('./superadmin/home/index');
                        }
                        if (data.idlevel == 1) {
                            window.location.href = ('./admin/home/index');
                        }
                        if (data.idlevel == 2) {
                            window.location.href = ('./kasir/penjualan/input');
                        }
                    }
                })
            }
        }
    });

    return false;
});