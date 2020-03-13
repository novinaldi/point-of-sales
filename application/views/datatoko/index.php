<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-primary btn-sm btnTambahdata">
                        <i class="fa fa-fw fa-tasks"></i> Tambah Toko
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <div class="viewform" style="display: none;"></div>
                <table class="datatoko table table-bordered table-sm" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Toko</th>
                            <th>Alamat</th>
                            <th>Telp</th>
                            <th>Pemilik</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <script src="<?= base_url('assets/js/scripttoko.js') ?>"></script>
                </table>
            </div>
        </div>
    </div>
</div>