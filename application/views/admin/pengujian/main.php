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
                    <?php $this->view('session'); ?>
                    <div class="card-header">
                        <i class="fas fa-table"></i> Uji Akurasi
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Admin/Pengujian/prosesUji') ?>" method="post">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Data latih</label>
                                        <select name="data_latih" class="form-control" id="">
                                            <option value="">-- Data Latih --</option>
                                            <option value="50">50%</option>
                                            <option value="60">60%</option>
                                            <option value="70">70%</option>
                                            <option value="80">80%</option>
                                            <option value="90">90%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Data Uji</label>
                                        <input type="text" class="form-control" placeholder="Data uji" name="data_uji" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="">&nbsp;</label>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Proses Uji
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        $(document).on('change', 'select[name="data_latih"]', function(e) {
            e.preventDefault();
            let data_latih = $(this).val();
            let total = 100;
            let data_uji = total - data_latih;

            $('input[name="data_uji"]').val(data_uji);
        })
    })
</script>