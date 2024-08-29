<?php

use App\Illuminate\Request\Request;
use \App\Illuminate\Router\Facades\Router;
use \App\Illuminate\View\Facades\View;

Router::get('', function (Request $request) {
  $configs = json_decode(file_get_contents(__DIR__ . '/../../../../../../storage/data/phpspider.json'), true);
  $contents = $configs['contents'];
  view('index', [
    'configs' => $configs,
    "contents" => $contents,
  ]);
});
Router::get('/content', function (Request $request) {
  $configs = json_decode(file_get_contents(__DIR__ . '/../../../../../../storage/data/phpspider.json'), true);
  $contents = $configs['contents'];
  $content = $contents[$request->input('slug')];

  view('content', [
    'configs' => $configs,
    "contents" => $contents,
    "content" => $content,
  ]);
});
Router::get('/ob-spider', function (Request $request) {
  $configs = json_decode(file_get_contents(__DIR__ . '/../../../../../../storage/data/phpspider.json'), true);
  $contents = $configs['contents'];
  $content = $contents[$request->input('slug')];

  $config = $content;

  $config['db_config'] = [
    'host'  => env('DB_HOST') ?? '127.0.0.1',
    'port'  => env('DB_PORT') ?? 3306,
    'user'  => env('DB_USERNAME') ?? 'root',
    'pass'  => env('DB_PASSWORD') ?? 'root',
    'name'  => env('DB_DATABASE') ?? 'demo',
  ];
  $config['export'] = [
    'type' => 'db',
    'table' => "webspider_logs",
    'unique_column' => "url",
  ];
  $config['max_fields'] = 100;

  view('ob-spider', [
    'configs' => $configs,
    "contents" => $contents,
    "content" => $content,
    "config" => $config,
  ]);
});
Router::get('*', function () {
  View::make('404', ['title' => "404"]);
});
