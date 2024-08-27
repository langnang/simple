<?php

$configs = json_decode(file_get_contents(__DIR__ . '/../../../../../storage/data/phpspider.json'), true);
// var_dump($configs);

$_ENV = parse_ini_file(__DIR__ . '/.env');
// var_dump($_ENV);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bootstrap v4</title>

    <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/normalize.css@8.0.1/normalize.css">
    <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/animate.css@4.1.1/animate.min.css">
    <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link crossorigin="anonymous" rel="stylesheet" href="style.css">
</head>

<body>
    <div id="app" class="container">
        <h1 class="text-center">Bootstrap v4</h1>
        <div class="row">
            <div class="col">
                <div class="list-group">

                    <?php foreach ($configs['contents'] ?? [] as $slug => $content): ?>
                        <a href="?<?php echo $slug; ?>" class="list-group-item list-group-item-action py-2">
                            <?php echo $slug; ?>
                            <small><?php echo $content['description'] ?? ''; ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script crossorigin="anonymous" src="https://unpkg.com/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script crossorigin="anonymous" src="https://unpkg.com/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script crossorigin="anonymous" src="https://unpkg.com/mockjs@1.1.0/dist/mock-min.js"></script>
    <script crossorigin="anonymous" src="https://unpkg.com/holderjs@2.9.9/holder.min.js"></script>

    <script crossorigin="anonymous" src="script.js"></script>
</body>

</html>