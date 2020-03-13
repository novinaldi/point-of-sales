<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    tampidatastokmasuk();
});

function tampidatastokmasuk() {
    table = $('.datastokmasuk').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": './ambildatastokmasuk',
            "type": "POST"
        },


        "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "width": 5
            },
            {
                "targets": [4],
                "orderable": false,
            },
            {
                "targets": [6],
                "orderable": false,
            }
        ],

    });
}

function hapus(id) {
    Swal.fire({
        showClass: {
            popup: 'animated fadeInDown faster'
        },
        hideClass: {
            popup: 'animated fadeOutUp faster'
        },
        title: 'Hapus',
        text: "Yakin Hapus Log Stok Masuk ini ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Apuih !',
        cancelButtonText: 'Ijan !'
    }).then((result) => {
        if (result.value) {

            // Swal.fire(
            //     'Deleted!',
            //     'Your file has been deleted.',
            //     'success'
            // )
            $.ajax({
                type: "post",
                url: "./hapuslogstokmasuk",
                data: "&id=" + id,
                cache: false,
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        $.toast({
                            heading: 'Alhamdulillah',
                            text: response.sukses,
                            showHideTransition: 'fade',
                            icon: 'error',
                            bgColor: '#03bd1f',
                            textColor: 'white',
                            position: 'top-center'
                        });
                        tampidatastokmasuk();
                    }
                },
                error: function(e) {
                    $.toast({
                        heading: 'Error',
                        text: 'Data Gagal di Eksekusi',
                        showHideTransition: 'fade',
                        icon: 'error',
                        bgColor: '#FF1356',
                        textColor: 'white',
                        position: 'top-center'
                    })
                }
            });
        }
    })
}

function edit(id) {
    $.ajax({
        url: "./editstokmasuk",
        type: 'POST',
        data: "&id=" + id,
        cache: false,
        success: function(response) {
            $('.viewedit').show();
            $('.viewedit').html(response);
            $('#modaledit').on('shown.bs.modal', function(e) {
                $('#jml').focus();
            })
            $('#modaledit').modal('show');
        }
    });
}
</script>
<div class="viewedit" style="display: none;"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-warning"
                        onclick="window.location.href=('<?= site_url('admin/stok/input') ?>')">
                        <i class="fa fa-fw fa-hand-point-left"></i> Kembali
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <div class="col col-lg-12">
                    <table class="table table-sm table-bordered datastokmasuk">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl.Masuk</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Jml</th>
                                <th>User Input</th>
                                <th></th>
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