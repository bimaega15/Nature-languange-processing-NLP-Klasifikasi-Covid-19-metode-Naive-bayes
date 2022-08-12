<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama_file; ?></title>
</head>
<style>
    .area {
        word-break: break-all;
        word-wrap: break-word;
        width: 100%;
    }
</style>

<body>
    <div class="area">
        <?= $row->output; ?>
    </div>
</body>

</html>