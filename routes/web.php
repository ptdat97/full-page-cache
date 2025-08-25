<?php

use Botble\Base\Facades\AdminHelper;
use Botble\FullPageCache\Http\Controllers\FullPageCacheController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'full-page-cache', 'as' => 'full-page-cache.'], function () {
        Route::resource('', FullPageCacheController::class)->parameters(['' => 'full-page-cache']);
        Route::get('full-page-caches/clear', [FullPageCacheController::class, 'clear'])->name('full-page-cache.clear');
    });
});
