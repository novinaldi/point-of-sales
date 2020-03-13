$(document).on('click', '#btnbataltransaksi', function () {
    batalkantransaksi();
});
$(document).on('click', '#btnsimpantransaksi', function () {
    simpandetail();
});
$(document).on('click', '#btndatapenjualan', function () {
    window.location.href = ("./data");
});
$(document).on('keydown', '#hargax', function () {
    if (event.keyCode == 113) {
        event.preventDefault();
        carisatuan();
    }
});
$(document).on('keydown', '#jml', function () {
    if (event.keyCode == 13) {
        simpandetail();
    }
    if (event.keyCode == 112) {
        event.preventDefault();
        $('#hargax').focus();
    }
});
$(document).on('keydown', 'body', function (e) {
    if (e.keyCode == 27) {
        window.location.reload();
    }
});
$(document).on('click', '#btnsimpanproduk', function () {
    simpandetail();
});
$(document).on('click', '#btncariproduk', function () {
    cariproduk();
});
$(document).on('keydown', '#kode', function () {
    //tekan F4
    if (event.keyCode == 115) {
        event.preventDefault();
        batalkantransaksi();
    }
    //tekan F3
    if (event.keyCode == 114) {
        event.preventDefault();
        pembayaran();
    }
    // Tekan F2
    if (event.keyCode == 113) {
        event.preventDefault();
        cariproduk();
    }
    if (event.keyCode == 13) {
        ambildataproduk();
    }
});
$(document).on('click', '#btncarisatuan', function () {
    carisatuan();
});

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    tampildetailpenjualanbarang();
});

function cariproduk() {
    $.ajax({
        url: "./cariproduk",
        success: function (response) {
            $('.viewcariproduk').fadeIn();
            $('.viewcariproduk').html(response);
            $('#modalcariproduk').on('shown.bs.modal', function (e) {
                $('input[type="search"]').focus();
            });
            $('#modalcariproduk').modal('show');
        }
    });
}
function carisatuan() {
    $.ajax({
        url: "./carisatuan",
        success: function (response) {
            $('.viewcarisatuan').fadeIn();
            $('.viewcarisatuan').html(response);
            $('#modalcarisatuan').modal('show');
        }
    });
}
function ambildataproduk() {
    const kode = document.getElementById('kode');
    $.ajax({
        type: "post",
        url: "./ambildatadetailproduk",
        data: "&kode=" + kode.value,
        dataType: "json",
        success: function (response) {
            if (response.error) {
                $.toast({
                    heading: 'Error',
                    text: response.error,
                    hideAfter: 1000,
                    icon: 'error',
                    position: 'top-right'
                });
                kode.value = '';
                kode.focus();
            }
            if (response.sukses) {
                $('#namaproduk').val(response.sukses.namaproduk);
                $('#satnama').val(response.sukses.satnama);
                $('#satid').val(response.sukses.satid);
                $('#satqty').val(response.sukses.satqty);
                $('#hargax').val(response.sukses.hargajualx);
                $('#harga').val(response.sukses.hargajual);
                $('#stokproduk').val(response.sukses.stokproduk);

                $('#jml').focus();
            }
        }
    });
}

function tampildetailpenjualanbarang() {
    const nota = document.getElementById('nota');
    $.ajax({
        type: "post",
        url: "./tampildetailpenjualanbarang",
        data: "&nota=" + nota.value,
        cache: false,
        success: function (response) {
            $('.viewdetaildata').fadeIn();
            $('.viewdetaildata').html(response);
        }
    });
}

function simpandetail() {
    const nota = document.getElementById('nota');
    const kode = document.getElementById('kode');
    const harga = document.getElementById('harga');
    const jml = document.getElementById('jml');
    const satid = document.getElementById('satid');
    const satqty = document.getElementById('satqty');
    const stokproduk = document.getElementById('stokproduk');

    if (kode.value == '' || harga.value == 0 || harga.value == '' || jml.value == 0 || jml.value == '') {
        $.toast({
            heading: 'Maaf',
            text: 'Inputan Tidak Boleh ada yang kosong...!!!',
            hideAfter: 2000,
            icon: 'error',
            position: 'top-center'
        });
        kode.focus();
    } else {
        datasimpan = "&nota=" + nota.value + "&kode=" + kode.value + "&harga=" + harga.value + "&jml=" + jml.value + "&satid=" + satid.value + "&satqty=" + satqty.value;

        $.ajax({
            type: "post",
            url: "./simpantempjual",
            data: datasimpan,
            dataType: "json",
            success: function (response) {
                // alert(response);
                if (response.error) {
                    $.toast({
                        heading: 'Error',
                        text: response.error,
                        hideAfter: 2000,
                        icon: 'error',
                        position: 'top-center'
                    });
                }
                if (response.sukses) {
                    $.toast({
                        heading: 'Berhasil',
                        text: response.sukses,
                        hideAfter: 2000,
                        icon: 'success',
                        position: 'top-center'
                    });
                }
                kosongkan();
                tampildetailpenjualanbarang();
            }
        });
    }
}

function kosongkan() {
    document.getElementById('kode').value = '';
    document.getElementById('namaproduk').value = '';
    document.getElementById('satid').value = '';
    document.getElementById('satnama').value = '';
    document.getElementById('satqty').value = '';
    document.getElementById('jml').value = 1;
    document.getElementById('hargax').value = 0;
    document.getElementById('harga').value = 0;
    document.getElementById('stokproduk').value = 0;

    document.getElementById('kode').focus();
}

function hapusitem(id) {
    Swal.fire({
        showClass: {
            popup: 'animated flipInX faster'
        },
        hideClass: {
            popup: 'animated bounceOutRight'
        },
        title: 'Hapus Item',
        text: "Yakin item ini dihapus ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "./hapusitem",
                data: "&id=" + id,
                dataType: "json",
                success: function (response) {
                    if (response.sukses) {
                        $.toast({
                            icon: 'success',
                            text: response.sukses,
                            heading: 'Berhasil',
                            showHideTransition: 'plain',
                            position: 'top-center'
                        })
                    }
                    kosongkan();
                    tampildetailpenjualanbarang();
                },
                error: function () {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        text: 'Data tidak dapat di eksekusi',
                        title: 'Maaf',
                        showClass: {
                            popup: 'animated bounceInLeft'
                        }
                    })
                }
            });
        }
    })
}

function pembayaran() {
    const total = document.getElementById('totaljual');
    const nota = document.getElementById('nota');

    $.ajax({
        type: "post",
        url: "./simpanpenjualan",
        data: "&nota=" + nota.value + "&total=" + total.value,
        cache: false,
        success: function (response) {
            if (response == 'error') {
                $.toast({
                    heading: 'Error',
                    text: 'Tidak Ada Item yang bisa disimpan',
                    hideAfter: 2000,
                    icon: 'error',
                    position: 'top-center'
                });
                $('#kode').focus();
            } else {
                $('.viewpembayaran').show();
                $('.viewpembayaran').html(response);
                $('#modalpembayaran').on('shown.bs.modal', function (e) {
                    // $('#jmlbayarx').focus();
                    $('#diskonx').focus();
                })
                $('#modalpembayaran').modal('show');
            }
        },
        error: function () {
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                text: 'Data tidak dapat di eksekusi',
                title: 'Maaf',
                showClass: {
                    popup: 'animated bounceInLeft'
                }
            })
        }
    });
}

function batalkantransaksi() {
    Swal.fire({
        showClass: {
            popup: 'animated flipInX faster'
        },
        hideClass: {
            popup: 'animated bounceOutRight'
        },
        title: 'Hapus Item',
        text: "Yakin item ini dihapus ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "./bataltransaksi",
                dataType: 'json',
                success: function (response) {
                    if (response.sukses) {
                        $.toast({
                            heading: 'Berhasil',
                            text: response.sukses,
                            hideAfter: 2000,
                            icon: 'success',
                            position: 'top-center'
                        });
                        tampildetailpenjualanbarang();
                        kosongkan();
                    }

                },
                error: function () {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        text: 'Data tidak dapat di eksekusi',
                        title: 'Maaf',
                        showClass: {
                            popup: 'animated bounceInLeft'
                        }
                    })
                }
            });
        }
    })
}