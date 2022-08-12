<?php
$profile = check_profile();
$konfigurasi = konfigurasi();
?>
<header id="page-topbar">
    <div class="navbar-header">
        <div class="container-fluid">
            <div class="float-right">
                <div class="dropdown d-none d-lg-inline-block ml-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="mdi mdi-fullscreen"></i>
                    </button>
                </div>


                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="<?= base_url('img/konfigurasi/' . $konfigurasi->gambar_konfigurasi) ?>" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ml-1"><?= $profile->nama; ?></span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a class="dropdown-item" href="<?= base_url('Admin/Profile') ?>"><i class="bx bx-user font-size-16 align-middle mr-1"></i> Profile</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?= base_url('Login/Logout') ?>"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Logout</a>
                    </div>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="mdi mdi-settings-outline"></i>
                    </button>
                </div>

            </div>
            <div>
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="<?= base_url('Admin/Home') ?>" class="logo logo-dark">
                        <span class="logo-sm text-white font-weight-bold">
                            <!-- <img src="<?= base_url('img/konfigurasi/' . $konfigurasi->gambar_konfigurasi) ?>" alt="" height="20"> -->
                            Naive Bayes

                        </span>
                        <span class="logo-lg text-white font-weight-bold">
                            <!-- <img src="<?= base_url('img/konfigurasi/' . $konfigurasi->gambar_konfigurasi) ?>" alt="" height="17"> -->
                            Naive Bayes
                        </span>
                    </a>

                    <a href="<?= base_url('Admin/Home') ?>" class="logo logo-light">
                        <span class="logo-sm text-white font-weight-bold">
                            <!-- <img src="<?= base_url('img/konfigurasi/' . $konfigurasi->gambar_konfigurasi) ?>" alt="" height="20"> -->
                            Naive Bayes

                        </span>
                        <span class="logo-lg text-white font-weight-bold">
                            <!-- <img src="<?= base_url('img/konfigurasi/' . $konfigurasi->gambar_konfigurasi) ?>" alt="" height="19"> -->
                            Naive Bayes

                        </span>
                    </a>

                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect" id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </div>

        </div>
    </div>
</header>