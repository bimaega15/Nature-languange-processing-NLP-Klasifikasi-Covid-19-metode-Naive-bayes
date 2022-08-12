<?php
$konfigurasi = konfigurasi();
?>
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <?php $this->view('session'); ?>
                    <div class="bg-login text-center">
                        <div class="bg-login-overlay"></div>
                        <div class="position-relative">
                            <h5 class="text-white font-size-20">Welcome Back !</h5>
                            <p class="text-white-50 mb-0">Sign Into <?= $konfigurasi->gambar_konfigurasi; ?></p>
                            <a href="<?= base_url('Login') ?>" class="logo logo-admin mt-4">
                                <img src="<?= base_url('Qovex_v1.0.0/dist/') ?>assets/images/logo-sm-dark.png" alt="" height="30">
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-5">
                        <div class="p-2">
                            <form method="post" class="form-horizontal" action="<?= base_url('Login/process') ?>">

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input name="username" type="text" class="form-control" id="username" placeholder="Enter username" required>
                                </div>

                                <div class="form-group">
                                    <label for="userpassword">Password</label>
                                    <input name="password" type="password" class="form-control" id="userpassword" placeholder="Enter password" required>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">
                    <!-- <p>Don't have an account ? <a href="<?= base_url('Qovex_v1.0.0/dist/') ?>pages-register.html" class="font-weight-medium text-primary"> Signup now </a> </p> -->
                    <p>© 2020 TEA. Created<i class="mdi mdi-heart text-danger"></i> by Bima Ega</p>
                </div>

            </div>
        </div>
    </div>
</div>