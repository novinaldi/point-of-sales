<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="<?= $this->config->item('author') . '|' . $this->config->item('phone') . '|' . $this->config->item('emailauthor'); ?>">
    <meta name="author"
        content="<?= $this->config->item('author') . '|' . $this->config->item('phone') . '|' . $this->config->item('emailauthor'); ?>">

    <title><?= $this->config->item('title') ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">


    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Sweetalert2 -->
    <script src="<?php echo base_url('assets/') ?>vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link href="<?php echo base_url('assets/') ?>vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet"
        type="text/css">
    <link href="<?php echo base_url('assets/') ?>css/animate.css" rel="stylesheet" type="text/css">
    <!-- Load Plugin Toast -->
    <script src="<?php echo base_url('assets\vendor\node_modules\jquery-toast-plugin\dist\jquery.toast.min.js') ?>">
    </script>
    <link href="<?php echo base_url('assets\vendor\node_modules\jquery-toast-plugin\dist\jquery.toast.min.css') ?>"
        rel="stylesheet" type="text/css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-landmark"></i> <?= $this->config->item('namatoko'); ?>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <?php $uri = $this->uri->segment(2); ?>
                    <li class="nav-item <?php if ($uri == 'penjualan') echo 'active'; ?>">
                        <a class="nav-link" href="<?= site_url('kasir/penjualan/input') ?>">Kasir Penjualan <span
                                class="sr-only">(current)</span></a>

                    </li>
                    <li class="nav-item <?php if ($uri == 'gantipassword') echo 'active'; ?>">
                        <a class="nav-link" href="<?= site_url('kasir/gantipassword/index') ?>">
                            <i class="fa fa-fw fa-key"></i> Ganti Password
                        </a>

                    </li>
                    <li class="nav-item <?php if ($uri == 'profil') echo 'active'; ?>">
                        <a class="nav-link" href="<?= site_url('kasir/profil/index') ?>">
                            <i class="fa fa-fw fa-user"></i> Profil
                        </a>

                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="<?= site_url('login/keluar') ?>" id="" role="button"
                            data-toggle="" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-white medium">Logout,
                                <?= $this->session->userdata('namauser'); ?></span>
                            <img class="img-profile rounded-circle" style="width: 30px;height: 30px;" src="<?php
                                                                                                            $foto = $this->session->userdata('foto');
                                                                                                            if ($foto == '' || $foto == NULL) {
                                                                                                                echo base_url('assets/img/user-avatar.png');
                                                                                                            } else {
                                                                                                                echo base_url($foto);
                                                                                                            }
                                                                                                            ?>">
                        </a>
                        <!-- Dropdown - User Information -->
                        <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div> -->
                    </li>

                </ul>
                <!-- <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form> -->
            </div>
        </div>
    </nav>
    <!-- <div class="container mt-3"> -->
    <div class="mt-3 mr-2 ml-2">
        {isi}
    </div>
    <!-- </div> -->
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

</body>

</html>