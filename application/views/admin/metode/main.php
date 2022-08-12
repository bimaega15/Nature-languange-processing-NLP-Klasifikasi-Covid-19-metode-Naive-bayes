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
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <?php $this->view('session'); ?>
                    <div class="card-header">
                        <i class="fas fa-table"></i> Analisa Sentimen
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Admin/Metode/analisa') ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Analisa Sentimen</label>
                                        <textarea id="text_sentimen" placeholder="Text Sentimen..." name="text_sentimen" class="form-control" id="text_sentimen">
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
    <!-- end row -->
</div>
<!-- End Page-content -->

<?= $footer; ?>
</div>
<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var editor = CKEDITOR.replace('text_sentimen', {
            extraPlugins: ['ckeditor_wiris', 'bidi', 'html5audio', 'video'],
            removePlugins: 'sourcearea',
            height: 300,
            filebrowserUploadMethod: 'form',
        });
        CKEDITOR.config.extraAllowedContent = 'audio[*]{*}';
        CKFinder.setupCKEditor(editor);

    })
</script>