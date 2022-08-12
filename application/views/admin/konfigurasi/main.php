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
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="<?= base_url('Admin/Konfigurasi/process') ?>" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Instansi</label>
                                                <input type="text" class="form-control" name="instansi_konfigurasi" value="<?= set_value('instansi_konfigurasi') != null ? set_value('instansi_konfigurasi') :  $row->instansi_konfigurasi; ?>" placeholder="Instansi..." required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nama Sistem</label>
                                                <input type="text" class="form-control" name="nama_konfigurasi" value="<?= set_value('nama_konfigurasi') != null ? set_value('nama_konfigurasi') :  $row->nama_konfigurasi; ?>" placeholder="Nama Sistem..." required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">No. HP</label>
                                                <input type="number" class="form-control" name="nohp_konfigurasi" value="<?= set_value('nohp_konfigurasi') != null ? set_value('nohp_konfigurasi') :  $row->nohp_konfigurasi; ?>" placeholder="Nama Sistem..." required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Alamat</label>
                                                <input type="text" class="form-control" name="alamat_konfigurasi" value="<?= set_value('alamat_konfigurasi') != null ? set_value('alamat_konfigurasi') :  $row->alamat_konfigurasi; ?>" placeholder="Instansi..." required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="text" class="form-control" name="email_konfigurasi" value="<?= set_value('email_konfigurasi') != null ? set_value('email_konfigurasi') : $row->email_konfigurasi; ?>" placeholder="Email ..." required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Created By</label>
                                                <input type="text" class="form-control" name="copyright_konfigurasi" value="<?= set_value('copyright_konfigurasi') != null ? set_value('copyright_konfigurasi') : $row->copyright_konfigurasi; ?>" placeholder="Created By ..." required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Gambar</label>
                                                <input type="file" class="form-control" name="gambar_konfigurasi">
                                                <?php
                                                if ($row->copyright_konfigurasi != null) { ?>
                                                    <div class="mt-3">
                                                        <img src="<?= base_url('img/konfigurasi/' . $row->gambar_konfigurasi) ?>" alt="Gambar konfigurasi" width="150px;" class="rounded">
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Tentang</label>
                                                <textarea id="tentang_konfigurasi" placeholder="tentang_konfigurasi..." name="tentang_konfigurasi" class="form-control" id="tentang_konfigurasi" required>
                                        <?= set_value('tentang_konfigurasi') != null ? set_value('tentang_konfigurasi') : $row->tentang_konfigurasi; ?>
                                    </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <button type="reset" class="btn btn-danger"><i class="fas fa-undo"></i> Reset</button>
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save    "></i> Submit</button>
                                            </div>
                                        </div>
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
        var editor = CKEDITOR.replace('tentang_konfigurasi', {
            extraPlugins: ['ckeditor_wiris', 'bidi', 'html5audio', 'video'],
            removePlugins: 'sourcearea',
            height: 300,
            filebrowserUploadMethod: 'form',
        });
        CKEDITOR.config.extraAllowedContent = 'audio[*]{*}';
        CKFinder.setupCKEditor(editor);

    })
</script>