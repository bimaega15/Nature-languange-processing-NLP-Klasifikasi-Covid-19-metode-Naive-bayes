<div class="card">
    <div class="card-header">
        <i class="fas fa-table"></i> Prior Probability
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <?php
            foreach ($perhitungan['totalDocument'] as $class => $value) :
                $text_class = '';
                switch ($class) {
                    case 1:
                        $text_class = 'positif';
                        break;
                    case 0:
                        $text_class = 'netral';
                        break;
                    case -1:
                        $text_class = 'negatif';
                        break;
                }
            ?>
                <tr>
                    <td>
                        <span class="text-capitalize">
                            <?= $text_class ?>
                        </span>
                    </td>
                    <td><?= $value ?></td>
                </tr>
            <?php
            endforeach;
            ?>

        </table>
    </div>
</div>
<div class="card mt-2">
    <div class="card-header">
        <i class="fas fa-table"></i> Dokumen yang diuji
    </div>
    <div class="card-body">
        <?php
        foreach ($perhitungan['elemenPerText'] as $text => $result) : ?>
            <strong>
                <?= $text ?>
            </strong>
            <table class="table table-bordered">
                <?php foreach ($result as $class => $value) :
                    $text_class = '';
                    switch ($class) {
                        case 1:
                            $text_class = 'positif';
                            break;
                        case 0:
                            $text_class = 'netral';
                            break;
                        case -1:
                            $text_class = 'negatif';
                            break;
                    }
                ?>
                    <tr>
                        <td class="text-capitalize"><?= $text_class ?></td>
                        <td><?= round($value, 3) ?></td>
                    </tr>

                <?php endforeach; ?>
            </table>
        <?php
        endforeach;
        ?>
    </div>
</div>

<div class="card mt-2">
    <div class="card-header">
        <i class="fas fa-table"></i> Hasil perhitungan klasifikasi
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <?php
            foreach ($perhitungan['totalHasil'] as $class => $result) :
                $text_class = '';
                switch ($class) {
                    case 1:
                        $text_class = 'positif';
                        break;
                    case 0:
                        $text_class = 'netral';
                        break;
                    case -1:
                        $text_class = 'negatif';
                        break;
                }
            ?>
                <tr>
                    <td><?= $text_class ?></td>
                    <td><?= $result; ?></td>
                </tr>
            <?php
            endforeach;
            ?>
        </table>
    </div>
</div>

<div class="card mt-2">
    <div class="card-header">
        <i class="fas fa-table"></i> Hasil Label
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>
                Hasil klasifikasi:
            </strong>
            <?php
            $class = $output['klasifikasi'];
            $text_class = '';
            switch ($class) {
                case 1:
                    $text_class = 'positif';
                    break;
                case 0:
                    $text_class = 'netral';
                    break;
                case -1:
                    $text_class = 'negatif';
                    break;
            }
            ?>
            <h3 class="text-success text-capitalize font-weight-bold">
                <?= $text_class; ?>
            </h3>
        </div>
        <div>
            <strong>
                Hasil perhitungan:
            </strong>
            <h3 class="text-success text-capitalize font-weight-bold">
                <?= $output['hasil']; ?>
            </h3>
        </div>
    </div>
</div>