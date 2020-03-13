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

    <title>Halaman Login Sistem | <?= $this->config->item('title') ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <script src="<?= base_url('assets/') ?>vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/sweetalert2/dist/sweetalert2.min.css">
    <style>
    .gambar {
        background-image: url(<?= base_url('assets/img/bg/bg.jpg') ?>);
        background-size: 100%;
    }
    </style>
</head>

<body class="gambar">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-12 col-md-12">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row justify-content-center">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang, Silahkan Login !</h1>
                                        <hr>
                                    </div>
                                    <?= form_open('login/validasiuser', ['class' => 'user formlogin']) ?>
                                    <div class="pesan" style="display: none;"></div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" autofocus
                                            autocomplete="off" placeholder="Inputkan ID User..." name="uid">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" autofocus
                                            autocomplete="off" placeholder="Inputkan Password Anda..." name="pass">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block btnlogin">
                                        <i class="fa fw fa-sign-in-alt"></i> Login
                                    </button>
                                    <?= form_close(); ?>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>
    <script src="<?= base_url('assets/js/login.js') ?>"></script>
</body>

</html>