<?php

use Illuminate\Route\Facades\Route;

Route::prefix(config('web-spider.alias'))->group(function () {
  Route::get('', '\Modules\WebSpider\Http\Controllers\WebSpiderController@index');
  Route::get('content', '\Modules\WebSpider\Http\Controllers\WebSpiderController@content');
  Route::get('ob-spider', '\Modules\WebSpider\Http\Controllers\WebSpiderController@ob_spider');
});
