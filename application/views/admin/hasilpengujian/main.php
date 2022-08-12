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
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Data latih</th>
                                        <th>Data uji</th>
                                        <th>Akurasi</th>
                                        <th>Precision</th>
                                        <th>Recall</th>
                                        <th class="text-center" width="20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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

<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            "ajax": {
                url: "<?= base_url('Admin/HasilPengujian/loadData') ?>",
            },
        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const id_pengujian = $(this).data("id_pengujian");
            Swal.fire({
                title: 'Deleted',
                text: "Yakin ingin menghapus item ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('Admin/HasilPengujian/delete') ?>",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            id_pengujian
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    data.msg,
                                    'success'
                                );
                                table.ajax.reload();

                            } else {
                                Swal.fire(
                                    'Deleted!',
                                    data.msg,
                                    'error'
                                )
                            }

                        },
                        error: function(x, t, m) {
                            console.log(x.responseText);
                        }
                    })
                }
            })
        })
    })
</script>