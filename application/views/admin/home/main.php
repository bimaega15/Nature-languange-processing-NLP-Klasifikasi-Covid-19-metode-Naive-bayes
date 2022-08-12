<?php
$konfigurasi = konfigurasi();
?>
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
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="mdi mdi-account-lock"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">Admin</div>
                            </div>
                        </div>
                        <h4 class="mt-4"><?= $admin; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="mdi mdi-file-table-box"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">Kata positif</div>
                            </div>
                        </div>
                        <h4 class="mt-4"><?= $positive_words; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="mdi mdi-file-table-box"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">Kata negatif</div>
                            </div>
                        </div>
                        <h4 class="mt-4"><?= $negative_words; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="mdi mdi-label"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">Label</div>
                            </div>
                        </div>
                        <h4 class="mt-4"><?= $label; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="mdi mdi-file-table-box"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">Stop word</div>
                            </div>
                        </div>
                        <h4 class="mt-4"><?= $stopword; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="mdi mdi-file-table-box"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">Stemming</div>
                            </div>
                        </div>
                        <h4 class="mt-4"><?= $stemming; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="mdi mdi-book"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">Hasil Sentimen</div>
                            </div>
                        </div>
                        <h4 class="mt-4"><?= $hasil; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm font-size-20 mr-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="mdi mdi-book-information-variant"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <div class="font-size-16 mt-2">Pengujian</div>
                            </div>
                        </div>
                        <h4 class="mt-4"><?= $pengujian; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <img src="<?= base_url('img/konfigurasi/' . $konfigurasi->gambar_konfigurasi); ?>" class="img-fluid" alt="Gambar Naive Bayes">
                            </div>
                            <div class="col-lg-8">
                                <h3 class="mb-3"> <u>Metode Naive Bayes</u> </h3>
                                <div class="text-dark tentang">
                                    <?= $konfigurasi->tentang_konfigurasi; ?>
                                </div>
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