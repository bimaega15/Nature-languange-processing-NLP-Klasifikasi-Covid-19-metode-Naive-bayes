<?php
$profile = check_profile();
$uri = $this->uri->segment(1);
$sub_uri = $this->uri->segment(2);
$konfigurasi = konfigurasi();
?><div class="vertical-menu">

    <div class="h-100">

        <div class="user-wid text-center py-4">
            <div class="user-img">
                <img src="<?= base_url('img/konfigurasi/' . $konfigurasi->gambar_konfigurasi) ?>" alt="" class="avatar-md mx-auto rounded-circle">
            </div>

            <div class="mt-3">
                <a href="#" class="text-dark font-weight-medium font-size-16"><?= $profile->nama ?></a>
                <p class="text-body mt-1 mb-0 font-size-13">Admin</p>

            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="<?= base_url('Admin/Home') ?>" class="waves-effect">
                        <i class="mdi mdi-airplay"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('Admin/Profile') ?>" class="waves-effect">
                        <i class="mdi mdi-face-profile"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('Admin/Users') ?>" class="waves-effect">
                        <i class="mdi mdi-account-lock"></i>
                        <span>Users</span>
                    </a>
                </li>

                <li class="menu-title">Data Master</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
                        <i class="mdi mdi-database"></i>
                        <span>Data Sentimen</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false">
                        <li><a href="<?= base_url('Admin/PositiveWords') ?>">Kata Positif</a></li>
                        <li><a href="<?= base_url('Admin/NegativeWords') ?>">Kata Negatif</a></li>
                        <li><a href="<?= base_url('Admin/Stopwords') ?>">Stop word</a></li>
                        <li><a href="<?= base_url('Admin/Stemming') ?>">Stemming</a></li>
                    </ul>
                </li>

                <li>
                    <a href="<?= base_url('Admin/Label') ?>" class="waves-effect">
                        <i class="mdi mdi-label"></i>
                        <span>Data Label</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('Admin/Metode') ?>" class="waves-effect">
                        <i class="mdi mdi-calculator"></i>
                        <span>Naive Bayes</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('Admin/Pengujian') ?>" class="waves-effect">
                        <i class="mdi mdi-file-table"></i>
                        <span>Pengujian</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
                        <i class="mdi mdi-book-search"></i>
                        <span>Hasil Sentimen</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false">
                        <li><a href="<?= base_url('Admin/HasilSentimen') ?>">Hasil Sentimen</a></li>
                        <li><a href="<?= base_url('Admin/HasilPengujian') ?>">Hasil Pengujian</a></li>
                    </ul>
                </li>

                <li class="menu-title">Konfigurasi</li>
                <li>
                    <a href="<?= base_url('Admin/Konfigurasi') ?>" class="waves-effect">
                        <i class="fas fa-cog"></i>
                        <span>Konfigurasi</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('Login/logout') ?>" class="waves-effect">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
                <li>
                    <a>
                        &emsp;
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>