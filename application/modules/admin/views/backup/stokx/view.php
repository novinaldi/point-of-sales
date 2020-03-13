<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/js/jquery.hotkeys.js') ?>"></script>
<script src="<?= base_url('assets/js/stok.js') ?>"></script>
<div class="viewform" style="display: none;"></div>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <button type="button" class="btn btn-info" onclick="lihatdatastokmasuk();">
                    <i class="fa fa-fw fa-hand-point-right"></i> Lihat Data Stok Masuk
                </button>
            </h6>
        </div>
        <div class="card-body">
            <div class="pesan" style="display: none;"></div>
            <div class="row">
                <div class="col col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Inputkan Kode Barcode
                            </h6>
                        </div>
                        <?= form_open('admin/stok/simpankodeproduk', ['class' => 'formsimpan']) ?>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Kode Barcode</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-lg" name="kode" id="kode"
                                        placeholder="Input Barcode" autofocus>
                                    <div class="input-group-append">
                                        <button class="btn btn-info btncariproduk" type="button">
                                            <i class="fa fa-fw fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label>Qty</label>
                                <input type="number" class="form-control form-control-sm" name="qty" value="1" id="qty"
                                    style="text-align: center;">
                            </div>
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" class="form-control form-control-sm" id="namaproduk"
                                    name="namaproduk" readonly>
                                <input type="hidden" name="idproduk" id="idproduk">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block btnsimpan">
                                    Simpan
                                </button>
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>



                <div class="col col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Data Stok Produk
                            </h6>
                        </div>
                        <div class="card-body">

                            <table class="table table-bordered table-sm datastokproduk">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barcode</th>
                                        <th>Nama Produk</th>
                                        <th>Stok</th>
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
</div>