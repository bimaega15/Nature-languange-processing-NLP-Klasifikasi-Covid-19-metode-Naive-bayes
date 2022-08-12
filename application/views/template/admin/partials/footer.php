<?php
$konfigurasi = konfigurasi();
?>
<footer class="footer" style="z-index: 9999;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                © <?= $konfigurasi->copyright_konfigurasi ?>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-right d-none d-sm-block">
                    Design & Develop by <?= $konfigurasi->nama_konfigurasi; ?>
                </div>
            </div>
        </div>
    </div>
</footer>