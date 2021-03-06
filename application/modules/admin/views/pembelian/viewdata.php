<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-warning"
                        onclick="window.location.href=('<?php echo site_url('admin/pembelian/input') ?>')">
                        <i class="fa fa-fw fa-hand-point-left"></i> Kembali
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-bordered" id="seluruhdatapembelian">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No.Faktur</th>
                            <th>Tgl.Faktur</th>
                            <th>Supplier</th>
                            <th>Jumlah Item</th>
                            <th>Total Pembelian (Rp)</th>
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
    table = $('#seluruhdatapembelian').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": './ambilseluruhdatapembelian',
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
            }, {
                "targets": [5],
                "orderable": false,
            },
            {
                "targets": [6],
                "orderable": false,
            }
        ],

    });
}

function hapus(nota) {
    Swal.fire({
        title: 'Hapus Transaksi',
        text: "Yakin Menghapus Transaksi Pembelian ini ?, semua data detail yang ada juga ikut terhapus",
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
                data: "&nota=" + nota,
                dataType: "json",
                success: function(response) {
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
                error: function() {
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
</script>