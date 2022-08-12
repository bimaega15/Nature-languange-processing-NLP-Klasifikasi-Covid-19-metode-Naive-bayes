<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>
        <?= $title; ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/images/favicon.ico">

    <!-- jquery.vectormap css -->
    <link href="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('assets/datatables/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('node_modules/sweetalert2/dist/sweetalert2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap-datepicker-master/dist/css/bootstrap-datepicker.min.css">
</head>

<body data-layout="detached" data-topbar="colored">

    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?= $header; ?>

            <!-- ========== Left Sidebar Start ========== -->
            <?= $sidebar; ?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <?= $content; ?>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

    </div>
    <!-- end container-fluid -->

    <!-- Right Sidebar -->
    <?= $right_sidebar ?>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/node-waves/waves.min.js"></script>

    <script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/js/app.js"></script>
    <script src="<?= base_url('assets/') ?>ckeditor/ckeditor.js"></script>
    <script src="<?= base_url('assets/') ?>ckeditor/adapters/jquery.js"></script>
    <script src="<?= base_url('assets/') ?>ckfinder/ckfinder.js"></script>
    <script src="<?= base_url('assets/') ?>bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>


    <script src="<?= base_url('node_modules/autonumeric/dist/autoNumeric.min.js') ?>"></script>
    <script src="<?= base_url('node_modules/sweetalert2/dist/sweetalert2.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/dataTables.bootstrap4.min.js') ?>"></script>



</body>

</html>