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

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-landmark"></i>
                </div>
                <div class="sidebar-brand-text mx-3">
                    SuperAdmin
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            {menu}



            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link text-primary" href="<? //= site_url('superadmin/manajemenuser/index') 
                                                                    ?>"
                                id="alertsDropdown" role="button">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-primary"></i> Manajemen User
                            </a>
                        </li> -->

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= $this->session->userdata('namauser'); ?>
                                </span>

                                <img class="img-profile rounded-circle" src="<?php
                                                                                $foto = $this->session->userdata('foto');
                                                                                if ($foto == '' || $foto == NULL) {
                                                                                    echo base_url('assets/img/user-avatar.png');
                                                                                } else {
                                                                                    echo base_url($foto);
                                                                                }
                                                                                ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Level : <?= $this->session->userdata('namalevel'); ?>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= site_url('superadmin/gantipassword/index') ?>">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= site_url('login/keluar') ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">{judul}</h1>
                    {isi}
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2020, Version 1.0</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

</body>

</html>