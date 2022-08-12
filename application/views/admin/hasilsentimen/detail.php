<?php $profile = check_profile(); ?>
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
        <?php
        $sentimen = $naive_bayes['sentimen'];
        $perhitungan = $naive_bayes['perhitungan'];
        $output = $naive_bayes['output'];

        ?>
        <div class="row">
            <div class="col-xl-12">
                <?php
                $this->view('admin/metode/partial/textprocessing', [
                    'sentimen' => $sentimen
                ]);
                ?>

                <?php
                $this->view('admin/metode/partial/analisa', [
                    'perhitungan' => $perhitungan,
                    'output' => $output,
                ]);
                ?>

            </div>
        </div>



    </div>
    <!-- end row -->
</div>
<!-- End Page-content -->

<?= $footer; ?>
</div>