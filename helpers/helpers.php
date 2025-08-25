<?php

namespace Botble\FullPageCache\Helpers;

use Illuminate\Support\Facades\File;

class CacheHelper
{
    protected static $path = null;

    protected static function getPath()
    {
        if (!self::$path) {
            self::$path = storage_path('fullpage-cache');
        }
        return self::$path;
    }

    public static function clearAll()
    {
        $path = self::getPath();
        if (File::exists($path)) {
            File::cleanDirectory($path);
        }
    }

    public static function clearByUrl(string $url)
    {
        $file = self::getPath() . '/' . md5($url) . '.html';
        if (File::exists($file)) {
            File::delete($file);
        }
    }

    function clear_full_page_cache(): void
    {
        $path = public_path('cache/full-page');

        if (file_exists($path)) {
            \File::deleteDirectory($path);
        }
    }
}
