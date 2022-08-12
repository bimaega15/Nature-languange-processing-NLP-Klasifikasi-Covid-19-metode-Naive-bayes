<?php
$konfigurasi = konfigurasi();
?>
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                2021 © <?= $konfigurasi->nama_sistem; ?>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-right d-none d-sm-block">
                    Design & Develop by <?= $konfigurasi->pembuat_sistem; ?>
                </div>
            </div>
        </div>
    </div>
</footer>