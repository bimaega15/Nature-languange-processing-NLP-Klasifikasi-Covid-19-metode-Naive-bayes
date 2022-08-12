<div class="main-content">

    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18"><?= $title; ?></h4>

                    <div class="page-title-right">
                        <?= $breadcrumbs; ?>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <?php $this->view('session'); ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th class="text-center" width="20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $profile->nama ?></td>
                                        <td><?= $profile->username ?></td>
                                        <td class="text-center">
                                            <a href="#" data-toggle="modal" data-target="#modalProfile" class="btn btn-warning btn-edit-profile" data-id="<?= $profile->id_admin; ?>"><i class="fas fa-pencil-alt    "></i> Edit</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end row -->
</div>
<!-- End Page-content -->

<?= $footer; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="modalProfile" tabindex="-1" aria-labelledby="modalProfileLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProfileLabel"> My Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/Profile/process') ?>" method="post">
                <input type="hidden" name="id_admin" value="<?= $profile->id_admin; ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input placeholder="Nama Admin..." type="text" name="nama" required class="form-control" id="nama" value="<?= $profile->nama; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input placeholder="Username..." type="text" name="username" required class="form-control" id="username" value="<?= $profile->username; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input placeholder="Password..." type="password" name="password" class="form-control" id="password">
                            <input type="hidden" name="password_old" value="<?= $profile->password; ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
                    <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>