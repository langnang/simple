<?php

use Illuminate\Router\Facades\Router;
use Modules\WebSpider\Http\Controllers\WebSpiderController;

Router::prefix(config('this.alias'))->group(function () {
  Router::get('', [WebSpiderController::class, 'index']);
  Router::get('content', '\Modules\WebSpider\Http\Controllers\WebSpiderController@content');
  Router::get('ob-spider', '\Modules\WebSpider\Http\Controllers\WebSpiderController@ob_spider');
});
