$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    tidakaktif();
    tampildatadetailpembelian();
});
$(document).on('click', '#btndatapembelian', function () {
    window.location.href = ('./data');
});
$(document).on('keydown', '#kode', function () {
    if (event.keyCode == 113) {
        event.preventDefault();
        cariproduk();
    }
    if (event.keyCode == 13) {
        ambildataproduk();
    }

});
$(document).on('keydown', '#jml', function () {
    if (event.keyCode == 13) {
        simpandetailpembelian();
    }

});
$(document).on('keydown', '#hargabelix', function () {
    if (event.keyCode == 113) {
        event.preventDefault();
        carisatuan();
    }

});
$(document).on('click', '#btnsimpanproduk', function () {
    simpandetailpembelian();

});
$(document).on('click', '#btnbatalkantransaksi', function () {
    batalkantransaksi();

});
$(document).on('click', '#btnsimpanfaktur', function () {
    simpanpembelian();
});
$(document).on('click', '#btncarisatuan', function () {
    carisatuan();
});
$(document).on('click', '#btncarisupplier', function () {
    carisupplier();
});
$(document).on('click', '#btncariproduk', function () {
    cariproduk();
});
$(document).on('keydown', '#nota', function () {
    if (event.keyCode == 113) {
        event.preventDefault();
        carisupplier();
    }
    if (event.keyCode == 13) {
        ambildetailberdasarkanfaktur();
        tampildatadetailpembelian();
    }
});

$(document).on('keydown', '#tgl', function () {
    if (event.keyCode == 27) {
        event.preventDefault();
        $('#nota').focus();
    }
})

$(document).on('keydown', 'body', function () {
    if (event.keyCode == 27) {
        event.preventDefault();
        $('#nota').focus();
    }
    if (event.keyCode == 115) {
        event.preventDefault();
        batalkantransaksi();
    }
})

function carisupplier() {
    $.ajax({
        url: "./carisupplier",
        success: function (response) {
            $('.viewcarisup').fadeIn();
            $('.viewcarisup').html(response);
            $('#modalcarisupplier').on('shown.bs.modal', function (e) {
                $('input[type="search"]').focus();
            });
            $('#modalcarisupplier').modal('show');
        }
    });
}

function cariproduk() {
    $.ajax({
        url: "./cariproduk",
        success: function (response) {
            $('.viewcariproduk').fadeIn();
            $('.viewcariproduk').html(response);
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

function simpanpembelian() {
    const nota = document.getElementById('nota');
    const tgl = document.getElementById('tgl');
    const supid = document.getElementById('supid');

    if (nota.value == '' || tgl.value == '') {
        $.toast({
            heading: 'Maaf',
            text: 'Nota dan Tgl.Faktur tidak boleh Kosong',
            position: 'top-center',
            icon: 'warning',
            hideAfter: 2000,
            bgColor: '#f00202',
            textColor: 'white'
        });
        nota.focus();
    } else {
        datasimpan = "&nota=" + nota.value + "&tgl=" + tgl.value + "&supid=" + supid.value;
        $.ajax({
            type: "post",
            url: "./simpanfakturpembelian",
            data: datasimpan,
            dataType: "json",
            success: function (response) {
                if (response.sukses) {
                    $.toast({
                        heading: 'Berhasil',
                        text: response.sukses,
                        position: 'top-center',
                        icon: 'success',
                        hideAfter: 2000,
                        bgColor: '#04c21d',
                        textColor: 'white'
                    });
                    aktifkan();
                    document.getElementById('kode').focus();
                }
            },
            error: function () {
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    text: 'Data tidak dapat di eksekusi',
                    title: 'Maaf',
                    showClass: {
                        popup: 'animated fadeInDown faster'
                    },
                    hideClass: {
                        popup: 'animated fadeOutUp faster'
                    }
                })
            }
        });
    }
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
                    icon: 'error'
                })
            }
            if (response.sukses) {
                $('#namaproduk').val(response.sukses.namaproduk);
                $('#satnama').val(response.sukses.satnama);
                $('#satid').val(response.sukses.satid);
                $('#satqty').val(response.sukses.satqty);
                $('#hargajualx').val(response.sukses.hargajualx);
                $('#hargajual').val(response.sukses.hargajual);

                $('#hargabelix').focus();
            }
        }
    });
}

function batalkantransaksi() {
    const nota = document.getElementById('nota');

    Swal.fire({
        title: 'Batal Transaksi',
        text: "Yakin Batalkan Transaksi ?, semua data detail yang ada juga ikut terhapus",
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
                url: "./batalkantransaksi",
                data: "&nota=" + nota.value,
                dataType: "json",
                success: function (response) {
                    if (response.sukses) {
                        let timerInterval
                        Swal.fire({
                            showClass: {
                                popup: 'animated fadeInDown faster'
                            },
                            hideClass: {
                                popup: 'animated fadeOutUp faster'
                            },
                            title: response.sukses,
                            html: 'Silahkan Tunggu <b></b> milliseconds.',
                            timer: 500,
                            timerProgressBar: true,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                    const content = Swal.getContent()
                                    if (content) {
                                        const b = content.querySelector('b')
                                        if (b) {
                                            b.textContent = Swal.getTimerLeft()
                                        }
                                    }
                                }, 100)
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.reload();
                            }
                        })

                    }
                },
                error: function () {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        text: 'Data tidak dapat di eksekusi',
                        title: 'Maaf',
                        showClass: {
                            popup: 'animated fadeInDown faster'
                        },
                        hideClass: {
                            popup: 'animated fadeOutUp faster'
                        }
                    })
                }
            });
        }
    })
}

function simpandetailpembelian() {
    const nota = document.getElementById('nota');
    const kode = document.getElementById('kode');
    const satid = document.getElementById('satid');
    const satqty = document.getElementById('satqty');
    const jml = document.getElementById('jml');
    const hargabeli = document.getElementById('hargabeli');

    data = "&nota=" + nota.value + "&kode=" + kode.value + "&satid=" + satid.value + "&satqty=" + satqty.value +
        "&jml=" + jml.value + "&hargabeli=" + hargabeli.value;

    if (nota.value == '' || kode.value == '') {
        $.toast({
            heading: 'Maaf',
            text: 'Pastikan <strong>No.Faktur dan Kode Produk tidak boleh Kosong...</strong>',
            position: 'top-center',
            icon: 'warning',
            hideAfter: 2000,
            bgColor: '#f00202',
            textColor: 'white'
        });
        kode.focus();
    } else {
        $.ajax({
            type: "post",
            url: "./simpandetailpembelian",
            data: data,
            cache: false,
            dataType: 'json',
            success: function (response) {
                if (response.sukses) {
                    $.toast({
                        heading: 'Berhasil',
                        text: response.sukses,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 1500,
                        position: 'top-center'
                    });
                    tampildatadetailpembelian();
                    kosongkandetailproduk();
                }
            },
            error: function () {
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    text: 'Data tidak dapat di eksekusi',
                    title: 'Maaf',
                    showClass: {
                        popup: 'animated fadeInDown faster'
                    },
                    hideClass: {
                        popup: 'animated fadeOutUp faster'
                    }
                })
            }
        });
    }
}


function tidakaktif() {
    $('#kode').attr('disabled', 'disabled');
    $('#btncariproduk').attr('disabled', 'disabled');
    $('#btncarisatuan').attr('disabled', 'disabled');
    $('#btnsimpanproduk').attr('disabled', 'disabled');
    $('#hargabelix').attr('disabled', 'disabled');
    $('#jml').attr('disabled', 'disabled');
}

function aktifkan() {
    $('#kode').removeAttr('disabled');
    $('#btncariproduk').removeAttr('disabled');
    $('#btncarisatuan').removeAttr('disabled');
    $('#btnsimpanproduk').removeAttr('disabled');
    $('#hargabelix').removeAttr('disabled');
    $('#jml').removeAttr('disabled');
}

function kosongkandetailproduk() {
    document.getElementById('kode').value = '';
    document.getElementById('namaproduk').value = '';
    document.getElementById('satid').value = '';
    document.getElementById('satnama').value = '';
    document.getElementById('satqty').value = '';
    document.getElementById('hargajualx').value = 0;
    document.getElementById('hargajual').value = 0;
    document.getElementById('hargabelix').value = '';
    document.getElementById('hargabeli').value = '';
    document.getElementById('jml').value = 1;

    document.getElementById('kode').focus();
}

function tampildatadetailpembelian() {
    const nota = document.getElementById('nota');

    $.ajax({
        type: "post",
        url: "./tampildatadetailpembelian",
        data: "&nota=" + nota.value,
        cache: false,
        success: function (response) {
            $('.viewdetaildata').fadeIn();
            $('.viewdetaildata').html(response);
        }
    });
}

function hapusitem(id) {
    Swal.fire({
        showClass: {
            popup: 'animated fadeInDown faster'
        },
        hideClass: {
            popup: 'animated fadeOutUp faster'
        },
        title: 'Hapus Item',
        text: "Yakin dihapus",
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
                        tampildatadetailpembelian();
                    }
                },
                error: function () {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        text: 'Data tidak dapat di eksekusi',
                        title: 'Maaf',
                        showClass: {
                            popup: 'animated fadeInDown faster'
                        },
                        hideClass: {
                            popup: 'animated fadeOutUp faster'
                        }
                    })
                }
            });
        }
    })
}

function ambildetailberdasarkanfaktur() {
    const nota = document.getElementById('nota');

    $.ajax({
        type: "post",
        url: "./ambildetailberdasarkanfaktur",
        data: "&nota=" + nota.value,
        dataType: "json",
        success: function (response) {
            if (response.error) {
                tidakaktif();
                nota.focus();
            }
            if (response.sukses) {
                aktifkan()
                $('#tgl').val(response.sukses.tgl);
                $('#supid').val(response.sukses.supid);
                $('#supnama').val(response.sukses.supnama);
                $('#nota').attr('disabled', 'disabled');
                $('#tgl').attr('disabled', 'disabled');
                $('#kode').focus();
            }
        }
    });
}