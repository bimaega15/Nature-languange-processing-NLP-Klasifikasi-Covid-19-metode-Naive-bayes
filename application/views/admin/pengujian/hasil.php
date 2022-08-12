<?php $profile = check_profile(); ?>
<img src="<?= base_url('img/loading/loading.svg') ?>" alt="" style="position: absolute; top:10%; left:50%; z-index: 999999;" class="d-none img-loading">
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
                    <div class="card-header">
                        <i class="fas fa-table"></i> Data Latih
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="table" id="dataTableLatih">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Text</th>
                                        <th>Klasifikasi</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        <i class="fas fa-table"></i> Data Uji
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="table" id="dataTableUji">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Text</th>
                                        <th>Klasifikasi</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        <i class="fas fa-table"></i> Hasil Pengujian
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="table" id="dataTableHasil">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Text</th>
                                        <th>Klasifikasi</th>
                                        <th>Score</th>
                                        <th>Prediksi</th>
                                        <th>Koreksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        <i class="fas fa-table"></i> Confusion Matrix
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Confusion Matrix</th>
                                        <th>Positif</th>
                                        <th>Netral</th>
                                        <th>Negatif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Positif</td>
                                        <td><?= $pPositif ?></td>
                                        <td><?= $pNetral ?></td>
                                        <td><?= $pNegatif ?></td>
                                    </tr>
                                    <tr>
                                        <td>Netral</td>
                                        <td><?= $netPositif ?></td>
                                        <td><?= $netNetral ?></td>
                                        <td><?= $netNegatif ?></td>
                                    </tr>
                                    <tr>
                                        <td>Negatif</td>
                                        <td><?= $nPositif ?></td>
                                        <td><?= $nNetral ?></td>
                                        <td><?= $nNegatif ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <h6>Akurasi: </h6>
                                <h3 class="text-success">
                                    <?= round(($accuracy * 100), 2) ?> %
                                </h3>
                            </div>
                            <div class="col-lg-4">
                                <h6>Precision: </h6>
                                <h3 class="text-success">
                                    <?= round(($precision * 100), 2) ?> %
                                </h3>
                            </div>
                            <div class="col-lg-4">
                                <h6>Recall: </h6>
                                <h3 class="text-success">
                                    <?= round(($recall * 100), 2) ?> %
                                </h3>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-12">
                                <form action="<?= base_url('Admin/Pengujian/submitPengujian') ?>" method="post">
                                    <div class="form-group">
                                        <button onclick="return confirm('Yakin ingin submit hasil pengujian ? ')" type="submit" class="form-control btn btn-primary">
                                            <i class="fas fa-paper-plane"></i> Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
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

<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#dataTableLatih').DataTable({
            "ajax": "<?= base_url('Admin/Pengujian/loadDataLatih') ?>",
        });

        var table = $('#dataTableUji').DataTable({
            "ajax": "<?= base_url('Admin/Pengujian/loadDataUji') ?>",
        });

        var table = $('#dataTableHasil').DataTable({
            "ajax": "<?= base_url('Admin/Pengujian/loadDataHasil') ?>",
        });
    })
</script>