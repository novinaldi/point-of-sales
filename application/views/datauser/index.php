<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?php echo base_url('assets/') ?>vendor/datatables/responsive/responsive.dataTables.min.css"
    rel="stylesheet">
<link href="<?php echo base_url('assets/') ?>vendor/datatables/responsive/rowReorder.dataTables.min.css"
    rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/responsive/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/responsive/dataTables.rowReorder.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-primary btn-sm tambahdatauser">
                        <i class="fa fa-fw fa-tasks"></i> Tambah User
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <div class="viewform" style="display: none;"></div>
                <table class="datauser table table-bordered table-sm" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID User</th>
                            <th>Nama User</th>
                            <th>Level</th>
                            <th>Toko</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/scriptuser.js') ?>"></script>