<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama_file; ?></title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Tahoma";
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table td,
        th {
            border: 1px solid black;
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        body {
            word-wrap: break-word;
            word-break: break-all;
        }
    </style>
</head>

<body>
    <?= $output; ?>
</body>

</html>s