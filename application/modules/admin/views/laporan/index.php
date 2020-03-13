<script>
$(document).on('click', '#btnlappembelian', function() {
    window.location.href = ("<?= site_url('admin/laporan/pembelian') ?>");
});
$(document).on('click', '#btnlappenjualan', function() {
    window.location.href = ("<?= site_url('admin/laporan/penjualan') ?>");
});
$(document).on('click', '#btnlappendapatan', function() {
    window.location.href = ("<?= site_url('admin/laporan/pendapatan') ?>");
});
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Pilih Laporan Yang Ingin di Tampilkan / di Cetak
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-4 col-md-12 mb-4" style="cursor: pointer;" id="btnlappembelian">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Cetak
                                            Pembelian</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-400">Per-Periode</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-truck-moving fa-3x text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-12 mb-4" style="cursor: pointer;" id="btnlappenjualan">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-success text-uppercase mb-1">Cetak
                                            Penjualan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-400">Per-Kategori</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-3x text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 mb-4" style="cursor: pointer;" id="btnlappendapatan">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-warning text-uppercase mb-1">Laporan
                                            Pendapatan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-400">Per-Tahun</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-money-check-alt fa-3x text-gray-600"></i>
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