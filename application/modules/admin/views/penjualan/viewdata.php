<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-warning" onclick="window.location.href=('./input')">
                        <i class="fa fa-fw fa-hand-point-left"></i> Kembali
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-bordered" id="seluruhdatapenjualan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No.Faktur</th>
                            <th>Tgl.Transaksi</th>
                            <th>Jumlah Item</th>
                            <th>Total Produk</th>
                            <th>Total Pembayaran</th>
                            <th>User Input</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    tampildata();
});

function tampildata() {
    table = $('#seluruhdatapenjualan').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": './ambilseluruhdatapenjualan',
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
            }, {
                "targets": [4],
                "orderable": false,
            },
            {
                "targets": [5],
                "orderable": false,

            },
            {
                "targets": [6],
                "orderable": false,
            },
            {
                "targets": [7],
                "orderable": false,
            }
        ],

    });
}

function hapus(nota) {
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
                url: "./hapustransaksipenjualan",
                data: "&nota=" + nota,
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        $.toast({
                            icon: 'success',
                            text: response.sukses,
                            heading: 'Berhasil',
                            showHideTransition: 'plain',
                            position: 'top-center'
                        })
                    }
                    tampildata();
                },
                error: function() {
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
</script>