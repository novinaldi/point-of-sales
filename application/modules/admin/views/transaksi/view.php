<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <div class="alert alert-info">
                        Silahkan Pilih Transaksi
                    </div>
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-4 btnpenjualan" style="cursor: pointer;">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">
                                            Penjualan</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-4x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4 btnpembelian" style="cursor: pointer;">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-success text-uppercase mb-1">
                                            Pembelian</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-truck-moving fa-4x text-gray-300"></i>
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
<script>
$(document).on('click', '.btnpenjualan', function(e) {
    window.location.href = ("<?= site_url('admin/penjualan/index') ?>")
});
$(document).on('click', '.btnpembelian', function(e) {
    window.location.href = ("<?= site_url('admin/pembelian/index') ?>")
});
</script>