<script>
$(document).on('click', '#btnkategori', function() {
    window.location.href = ("<?= site_url('admin/kategori/index') ?>");
});
$(document).on('click', '#btnsatuan', function() {
    window.location.href = ("<?= site_url('admin/satuan/index') ?>");
});
$(document).on('click', '#btnsupplier', function() {
    window.location.href = ("<?= site_url('admin/supplier/index') ?>");
});
$(document).on('click', '#btnproduk', function() {
    window.location.href = ("<?= site_url('admin/produk/index') ?>");
});
$(document).on('click', '#btnstokmasuk', function() {
    window.location.href = ("<?= site_url('admin/stok/input') ?>");
});
$(document).on('click', '#btnpembelian', function() {
    window.location.href = ("<?= site_url('admin/pembelian/input') ?>");
});
$(document).on('click', '#btnpenjualan', function() {
    window.location.href = ("<?= site_url('admin/penjualan/input') ?>");
});
$(document).on('click', '#btnlaporan', function() {
    window.location.href = ("<?= site_url('admin/laporan/index') ?>");
});
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Jalan Pintas Sistem
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-12 mb-4" style="cursor: pointer;" id="btnkategori">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Data
                                            Kategori</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-tasks fa-3x text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 mb-4" style="cursor: pointer;" id="btnsatuan">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-success text-uppercase mb-1">Data
                                            Satuan</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-tasks fa-3x text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 mb-4" style="cursor: pointer;" id="btnsupplier">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-warning text-uppercase mb-1">Data
                                            Supplier</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-3x text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 mb-4" style="cursor: pointer;" id="btnproduk">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-danger text-uppercase mb-1">Data
                                            Produk</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-archive fa-3x text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Transaksi -->
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-md-12 mb-4" style="cursor: pointer;" id="btnstokmasuk">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-danger text-uppercase mb-1">Transaksi
                                            Stok Masuk</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-store fa-3x text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 mb-4" style="cursor: pointer;" id="btnpembelian">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-success text-uppercase mb-1">Transaksi
                                            Pembelian</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-truck-moving fa-3x text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 mb-4" style="cursor: pointer;" id="btnpenjualan">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Transaksi
                                            Penjualan</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-3x text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-md-12 mb-4" style="cursor: pointer;" id="btnlaporan">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-warning text-uppercase mb-1">Laporan
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-print fa-3x text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>