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

  <script crossorigin="anonymous" src="https://unpkg.com/requirejs@2.3.7/require.js" data-main="/storage/js/requirejs.config.js?module=bootstrap4"></script>

</body>

</html>