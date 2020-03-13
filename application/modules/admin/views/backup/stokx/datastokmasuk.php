<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function(e) {
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
        }],

    });
});

function hapus(id) {
    Swal.fire({
        title: 'Hapus Stok Masuk',
        text: "Yakin data stok masuk ini dihapus",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "./hapusdatastokmasuk",
                data: "&id=" + id,
                dataType: "json",
                success: function(response) {
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
        }
    })
}

function edit(id) {
    $.ajax({
        type: "post",
        url: './formeditstokmasuk',
        data: "&id=" + id,
        cache: false,
        success: function(response) {
            $('.viewform').fadeIn();
            $('.viewform').html(response);
            $('#modaleditstokmasuk').modal('show');
        }
    });
}
</script>
<div class="viewform" style="display: none;"></div>
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
            <table class="table table-sm table-bordered datastokmasuk">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl.Input</th>
                        <th>Kode Barcode</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>User Input</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>