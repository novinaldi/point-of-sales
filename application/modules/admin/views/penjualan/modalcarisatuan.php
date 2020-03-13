<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<div class="modal fade bd-example-modal-lg" id="modalcarisatuan" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="exampleModalLabel">Cari Data Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="datasatuan table table-bordered table-sm" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Satuan</th>
                            <th>Jumlah Per-Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
function pilih(id, nama, x) {
    $('#satid').val(id);
    $('#satnama').val(nama);
    $('#satqty').val(x);
    $('#modalcarisatuan').on('hidden.bs.modal', function(e) {
        $('#hargax').focus();
    })
    $('#modalcarisatuan').modal('hide');
}
</script>
<script>
$(document).ready(function() {
    table = $('.datasatuan').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": './ambildatasatuan',
            "type": "POST"
        },


        "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "width": 5
            }, {
                "targets": [3],
                "orderable": false
            }

        ],
    });
});
</script>