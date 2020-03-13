<!-- Nav Item - Dashboard -->
<?php
if ($this->session->userdata('idlevel') == 3) {

?>
<li class="nav-item <?php if ($this->uri->segment('2') == 'home') echo 'active'; ?>">
    <a class="nav-link" href="<?= site_url('superadmin/home/index') ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Home</span></a>
</li>
<hr class="sidebar-divider">
<div class="sidebar-heading">
    Manajemen Data
</div>
<li class="nav-item <?php if ($this->uri->segment('2') == 'datatoko') echo 'active'; ?>">
    <a class="nav-link" href="<?= site_url('superadmin/datatoko/index') ?>">
        <i class="fas fa-fw fa-store-alt"></i>
        <span>Data Toko</span>
    </a>
</li>
<li class="nav-item <?php if ($this->uri->segment('2') == 'datauser') echo 'active'; ?>">
    <a class="nav-link" href="<?= site_url('superadmin/datauser/index') ?>">
        <i class="fas fa-fw fa-users"></i>
        <span>Data User</span>
    </a>
</li>
<hr class="sidebar-divider">
<div class="sidebar-heading">
    Utility
</div>
<li class="nav-item <?php if ($this->uri->segment('2') == 'utility') echo 'active'; ?>">
    <a class="nav-link" href="<?= site_url('superadmin/utility') ?>">
        <i class="fas fa-fw fa-cogs"></i>
        <span>Utility</span>
    </a>
</li>
<?php } ?>
<!-- Divider -->