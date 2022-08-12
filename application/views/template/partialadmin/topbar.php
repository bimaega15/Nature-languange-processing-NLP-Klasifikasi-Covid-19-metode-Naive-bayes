<?php
$profile = check_profile();
$uri = $this->uri->segment(1);
$sub_uri = $this->uri->segment(2);
$konfigurasi = konfigurasi();
?>
<style>
    .topnav .navbar-nav .nav-item .nav-link.active {
        color: rgba(255, 255, 255, .9) !important;
    }
</style>
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?= base_url('Admin/Home') ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?= base_url('img/konfigurasi/' . $konfigurasi->logo_sistem) ?>" alt="" height="20">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= base_url('img/konfigurasi/' . $konfigurasi->logo_sistem) ?>" alt="" height="18">
                    </span>
                </a>

                <a href="<?= base_url('Admin/Home') ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?= base_url('img/konfigurasi/' . $konfigurasi->logo_sistem) ?>" alt="" height="20">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= base_url('img/konfigurasi/' . $konfigurasi->logo_sistem) ?>" alt="" height="18">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="topnav">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link <?= $uri == 'Admin' && $sub_uri == 'Home' ? 'active' : '' ?>" href="<?= base_url('Admin/Home') ?>">
                                    Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?= $uri == 'Admin' && $sub_uri == 'Profile' ? 'active' : '' ?>" href="<?= base_url('Admin/Profile') ?>">
                                    My Profile
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link <?= $uri == 'Admin' && $sub_uri == 'DataAdmin' ? 'active' : '' ?>" href="<?= base_url('Admin/DataAdmin') ?>">
                                    Data Admin
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?= $uri == 'Admin' && $sub_uri == 'DataPpdb' ? 'active' : '' ?>" href="<?= base_url('Admin/DataPpdb') ?>">
                                    Data Ppdb
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?= $uri == 'Admin' && $sub_uri == 'Enkripsi' ? 'active' : '' ?>" href="<?= base_url('Admin/Enkripsi') ?>">
                                    Enkripsi
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?= $uri == 'Admin' && $sub_uri == 'Dekripsi' ? 'active' : '' ?>" href="<?= base_url('Admin/Dekripsi') ?>">
                                    Dekripsi
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?= $uri == 'Admin' && $sub_uri == 'Konfigurasi' ? 'active' : '' ?>" href="<?= base_url('Admin/Konfigurasi') ?>">
                                    Konfigurasi
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/images/users/avatar-2.jpg" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ml-1"><?= $profile->nama; ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a class="dropdown-item" href="<?= base_url('Admin/Profile') ?>"><i class="bx bx-user font-size-16 align-middle mr-1"></i> Profile</a>
                    <a class="dropdown-item d-block" href="<?= base_url('Admin/Konfigurasi') ?>"><i class="bx bx-wrench font-size-16 align-middle mr-1"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?= base_url('Login/logout') ?>"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Logout</a>
                </div>
            </div>

            <!-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="mdi mdi-settings-outline"></i>
                </button>
            </div> -->
        </div>
    </div>
</header>