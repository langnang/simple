<?php

require_once __DIR__ . '/core/util.php';
require_once __DIR__ . '/core/requests.php';
require_once __DIR__ . '/core/selector.php';
require_once __DIR__ . '/core/db.php';
require_once __DIR__ . '/core/log.php';
require_once __DIR__ . '/core/phpspider.php';


set_time_limit(0); //设置程序执行时间
ignore_user_abort(true); //设置断开连接继续执行
header('X-Accel-Buffering: no'); //关闭buffer
header('Content-type: text/html;charset=utf-8'); //设置网页编码

$_ENV = parse_ini_file(__DIR__ . '/.env');
var_dump($_ENV);

$configs = json_decode(file_get_contents(__DIR__ . '/../../../../../storage/data/phpspider.json'), true);

$config = $configs['contents']['bilianku'];
$config['db_config'] = [
    'host'  => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'port'  => $_ENV['DB_PORT'] ?? 3306,
    'user'  => $_ENV['DB_USERNAME'] ?? 'root',
    'pass'  => $_ENV['DB_PASSWORD'] ?? 'root',
    'name'  => $_ENV['DB_DATABASE'] ?? 'demo',
];
$config['export'] = [
    'type' => 'db',
    'table' => "webspider_logs",
    'unique_column' => 'url',
];
var_dump($config);

// var_dump($_ENV);
var_dump($_SERVER);
var_dump($_GET);
$spider = new phpspider\core\phpspider($config);
$spider->on_start = function ($phpspider) {
    var_dump('"on_start"');
};
$spider->on_download_page = function ($page, $phpspider) use ($config) {
    var_dump('"on_download_page","' . $page['url'] . '"');
    // dump($phpspider);
    // dump($page);
    $url = preg_replace("/:|\//", "_", $page['url']);
    $url = preg_replace("/_+/", "_", $url);
    if (!file_exists(__DIR__ . '/data')) {
        mkdir(__DIR__ . '/data');
    }
    if (!file_exists(__DIR__ . '/data/log')) {
        mkdir(__DIR__ . '/data/log');
    }
    if (!file_exists(__DIR__ . '/data/log/' . $config['slug'])) {
        mkdir(__DIR__ . '/data/log/' . $config['slug']);
    }
    file_put_contents(__DIR__ . '/data/log/' . $config['slug'] . '/' . $url . ".html", $page['raw']);
    // dump($url);
    // exit;
    // $page_html = "<div id=\"comment-pages\"><span>5</span></div>";
    // $index = strpos($page['row'], "</body>");
    // $page['raw'] = substr($page['raw'], 0, $index) . $page_html . substr($page['raw'], $index);
    return $page;
};
$spider->on_extract_page = function ($page, $data) use ($config) {
    var_dump('"on_extract_page","' . $page['url'] . '"');
    // $title = "[{$data['time']}]" . $data['title'];
    // $data['title'] = $title;
    if (isset($config['export']) && $config['export']['type'] == 'csv') {
        foreach ($data as $key => $value) {
            $data[$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
        }
    }
    $return = [
        "cid" => 1,
        "url" => $page['url'],
        "text" => json_encode($data, JSON_UNESCAPED_UNICODE),
        "updated_at" => date('Y-m-d H:i:s', time()),
    ];
    // $data['cid'] = 1;
    // $data['url'] = $page['url'];
    if ($config['max_fields'] !== 0) {
        var_dump($return);
    }
    // exit;
    return $return;
    // 返回false不处理，当前页面的字段不入数据库直接过滤
    // 比如采集电影网站，标题匹配到“预告片”这三个字就过滤
    //if (strpos($data['title'], "预告片") !== false)
    //{
    //    return false;
    //}
};
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
                        <a href="?slug=<?php echo $slug; ?>" class="list-group-item list-group-item-action py-2">
                            <?php echo $slug; ?>
                            <small><?php echo $content['description'] ?? ''; ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script crossorigin="anonymous" src="https://unpkg.com/requirejs@2.3.7/require.js" data-main="/storage/js/requirejs.config.js?title=WebSpider&loading=false"></script>

</body>

</html>

<?php

ob_start(); //打开输出缓冲控制
echo str_repeat(' ', 1024 * 4); //字符填充
$width = 1000;
$html = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx"><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';
echo sprintf($html, $width + 8, $width);
echo ob_get_clean(); //获取当前缓冲区内容并清除当前的输出缓冲
flush(); //刷新缓冲区的内容，输出
$length = 11;
// for ($i = 0; $i < $length; $i++) {
//     sleep(rand(1, 2));
//     $proportion = ($i + 1) / $length;
//     if ($i + 1 == $length) {
//         $msg = '同步完成';
//     } else {
//         $msg = '正在同步第' . ($i + 1) . '个用户';
//     }
//     $script = '<script>
//         document.getElementById("percent").innerText = "%u%%";
//         document.getElementById("progress").style.width = "%upx";
//         document.getElementById("msg").innerText = "%s";
//       </script>';
//     echo sprintf($script, intval($proportion * 100), intval(($i + 1) / $length) * $width, $msg);
//     echo ob_get_clean(); //获取当前缓冲区内容并清除当前的输出缓冲
//     flush(); //刷新缓冲区的内容，输出
// }
$spider->start();
?>