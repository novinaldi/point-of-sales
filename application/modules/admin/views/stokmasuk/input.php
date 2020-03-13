<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
$(document).on('click', '#btnsimpan', function() {
    simpanstok();
});
$(document).on('keydown', '#jml', function() {
    if (event.keyCode == 27) {
        event.preventDefault();
        $('#kode').focus();
    }
});
$(document).ready(function(e) {
    tampilstokproduk();
    $('[data-toggle="tooltip"]').tooltip()
    $(this).keydown(function(e) {
        if (e.keyCode == 112) {
            e.preventDefault();
            $('#kode').focus();
        }
        if (e.keyCode == 113) {
            e.preventDefault();
            cariproduk();
        }
    });
    $('#btncariproduk').click(function(e) {
        cariproduk();
    });
    $('#kode').keydown(function(e) {
        // e.preventDefault();
        if (e.keyCode == 13) {
            const kode = $(this).val();
            $.ajax({
                type: "post",
                url: "./detailproduk",
                data: "&kode=" + kode,
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Maaf',
                            text: response.error
                        });
                    }
                    if (response.sukses) {
                        $('#hargax').val(response.sukses.hargax);
                        $('#id').val(response.sukses.idproduk);
                        $('#harga').val(response.sukses.harga);
                        $('#namaproduk').val(response.sukses.namaproduk);
                        $('#satuan').val(response.sukses.satuan);
                        $('#jml').focus();
                    }
                },
                error: function(e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Maaf',
                        text: 'Data tidak dapat dieksekusi'
                    });
                }
            });
        }
    });
});

function cariproduk() {
    $.ajax({
        url: "./cariproduk",
        success: function(response) {
            $('.viewcariproduk').show();
            $('.viewcariproduk').html(response);
            $('#modalcariproduk').on('shown.bs.modal', function(e) {
                $('input[type="search"]').focus();
            })
            $('#modalcariproduk').modal('show');
        }
    });
}

function simpanstok() {
    const kode = document.getElementById('kode').value;
    const jml = document.getElementById('jml').value;

    if (kode == '' || jml == '' || jml == 0) {
        $.toast({
            heading: 'Maaf',
            text: 'Isian Kode atau Jumlah tidak boleh kosong',
            position: 'top-right',
            icon: 'error',
            hideAfter: 3000
        });
    } else {
        const data = "&kode=" + kode + "&jml=" + jml;
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/stok/simpandata') ?>",
            data: data,
            cache: false,
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('#kode').focus();
                    $.toast({
                        heading: 'Berhasil',
                        text: response.sukses,
                        position: 'top-center',
                        icon: 'success',
                        hideAfter: 2000
                    });
                    kosong();
                }
                tampilstokproduk();
            },
            error: function(e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Maaf',
                    text: 'Data tidak dapat dieksekusi'
                });
            }
        });
    }
}

function kosong() {
    document.getElementById('kode').value = '';
    document.getElementById('namaproduk').value = '';
    document.getElementById('hargax').value = '';
    document.getElementById('harga').value = '';
    document.getElementById('satuan').value = '';
    document.getElementById('jml').value = 1;
}

function tampilstokproduk() {
    table = $('.datastokproduk').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": './ambildatastokproduk',
            "type": "POST"
        },


        "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "width": 5
            },
            {
                "targets": [3],
                "orderable": false,
            }
        ],

    });
}

function eventsimpanstok(event) {
    if (event.keyCode == 13) {
        simpanstok();
    }
}
</script>
<div class="viewcariproduk" style="display: none;"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-success"
                        onclick="window.location.href=('<?= site_url('admin/stok/data') ?>')">
                        <i class="fa fa-fw fa-hand-point-right"></i> Lihat Log Data Stok Masuk
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td style="text-align: left; width: 20%">Inputkan Kode Produk</td>
                        <td style="text-align: left; width: 25%">Nama Produk</td>
                        <td style="text-align: left; width: 10%">Satuan</td>
                        <td style="text-align: left; width: 15%">Hrg.Jual(Rp)</td>
                        <td style="text-align: left; width: 10%">Jml.Masuk</td>
                        <td style="width: 5%;"></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-sm" name="kode" id="kode" autofocus>
                                <input type="hidden" name="id" id="id">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary btn-sm" type="button" id="btncariproduk"><i
                                            class="fa fa-fw fa-search"></i></button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="namaproduk" id="namaproduk" class="form-control form-control-sm"
                                readonly>
                        </td>
                        <td>
                            <input type="text" name="satuan" id="satuan" class="form-control form-control-sm" readonly>
                        </td>
                        <td>
                            <input type="text" name="hargax" id="hargax" class="form-control form-control-sm" readonly>
                            <input type="hidden" name="harga" id="harga">
                        </td>
                        <td>
                            <input type="number" name="jml" id="jml" onkeydown="eventsimpanstok(event);"
                                class="form-control form-control-sm" value="1">
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip"
                                data-placement="top" title="Simpan Data" id="btnsimpan">
                                <i class="fa fa-fw fa-plus-square"></i>
                            </button>
                        </td>
                    </tr>
                </table>

                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-bordered datastokproduk">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah Stok</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>