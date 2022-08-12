<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title><?= $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="home-btn d-none d-sm-block">
        <a href="<?= base_url('Login') ?>" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <?= $content; ?>

    <!-- JAVASCRIPT -->
    <script src="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/libs/node-waves/waves.min.js"></script>

    <script src="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/js/app.js"></script>

</body>

</html>