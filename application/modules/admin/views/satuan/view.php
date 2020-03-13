<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/js/satuan.js') ?>"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-primary btntambah">
                        <i class="fa fw fa-plus"></i> Tambah Satuan
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <table class="datasatuan table table-bordered table-sm" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Satuan</th>
                            <th>Jumlah Per-Satuan</th>
                            <th>Aksixx</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="viewform" style="display: none;"></div>