<!-- Nav Item - Dashboard -->
<?php
if ($this->session->userdata('idlevel') == 1) {

?>
<li class="nav-item <?php if ($this->uri->segment('2') == 'home') echo 'active'; ?>">
    <a class="nav-link" href="<?= site_url('admin/home/index') ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Home</span></a>
</li>
<hr class="sidebar-divider">
<?php $uri = $this->uri->segment('2'); ?>
<li
    class="nav-item <?php if ($uri == 'kategori' || $uri == 'satuan' || $uri == 'produk' || $uri == 'supplier') echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#dataMaster" aria-expanded="true"
        aria-controls="dataMaster">
        <i class="fas fa-fw fa-tasks"></i>
        <span>Data Master</span>
    </a>
    <div id="dataMaster"
        class="collapse <?php if ($uri == 'kategori' || $uri == 'satuan' || $uri == 'produk' || $uri == 'supplier') echo 'show'; ?>"
        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Input Data Master</h6>
            <a class="collapse-item <?php if ($uri == 'kategori') echo 'active'; ?>"
                href="<?= site_url('admin/kategori/index') ?>">
                <i class="fas fa-fw fa-file-import"></i> Kategori
            </a>
            <a class="collapse-item <?php if ($uri == 'satuan') echo 'active'; ?>"
                href="<?= site_url('admin/satuan/index') ?>">
                <i class="fas fa-fw fa-file-import"></i> Satuan
            </a>
            <a class="collapse-item <?php if ($uri == 'supplier') echo 'active'; ?>"
                href="<?= site_url('admin/supplier/index') ?>">
                <i class="fas fa-fw fa-users"></i> Supplier
            </a>
            <a class="collapse-item <?php if ($uri == 'produk') echo 'active'; ?>"
                href="<?= site_url('admin/produk/index') ?>">
                <i class="fas fa-fw fa-archive"></i> Produk
            </a>
        </div>
    </div>
</li>
<li class="nav-item <?php if ($uri == 'stok') echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transStok" aria-expanded="true"
        aria-controls="transStok">
        <i class="fas fa-fw fa-tasks"></i>
        <span>Transaksi Stok</span>
    </a>
    <div id="transStok" class="collapse <?php if ($uri == 'stok') echo 'show'; ?>" aria-labelledby="headingTwo"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Input Stok Masuk</h6>
            <a class="collapse-item <?php if ($uri == 'stok') echo 'active'; ?>"
                href="<?= site_url('admin/stok/input') ?>">
                <i class="fas fa-fw fa-store"></i> Stok Masuk
            </a>
        </div>
    </div>
</li>
<hr class="sidebar-divider">
<div class="sidebar-heading">
    Transaksi
</div>
<li class="nav-item <?php if ($uri == 'pembelian') echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transPembelian" aria-expanded="true"
        aria-controls="transPembelian">
        <i class="fas fa-fw fa-tasks"></i>
        <span>Pembelian</span>
    </a>
    <div id="transPembelian" class="collapse <?php if ($uri == 'pembelian') echo 'show'; ?>"
        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Pembelian</h6>
            <a class="collapse-item <?php if ($uri == 'pembelian') echo 'active'; ?>"
                href="<?= site_url('admin/pembelian/input') ?>">
                <i class="fas fa-fw fa-truck-moving"></i> Pembelian
            </a>
        </div>
    </div>
</li>
<li class="nav-item <?php if ($uri == 'penjualan') echo 'active'; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transPenjualan" aria-expanded="true"
        aria-controls="transPenjualan">
        <i class="fas fa-fw fa-tasks"></i>
        <span>Penjualan</span>
    </a>
    <div id="transPenjualan" class="collapse <?php if ($uri == 'penjualan') echo 'show'; ?>"
        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Penjualan</h6>
            <a class="collapse-item <?php if ($uri == 'penjualan') echo 'active'; ?>"
                href="<?= site_url('admin/penjualan/input') ?>">
                <i class="fas fa-fw fa-cart-plus"></i> Penjualan
            </a>
        </div>
    </div>
</li>
<hr class="sidebar-divider">
<div class="sidebar-heading">
    Laporan
</div>
<li
    class="nav-item <?php if ($this->uri->segment('2') == 'laporan' || $this->uri->segment('2') == 'laporan' || $this->uri->segment('2') == 'pembelian') echo 'active'; ?>">
    <a class="nav-link" href="<?= site_url('admin/laporan') ?>">
        <i class="fas fa-fw fa-file"></i>
        <span>Laporan</span></a>
</li>


<?php
}
?>

<!-- Divider -->