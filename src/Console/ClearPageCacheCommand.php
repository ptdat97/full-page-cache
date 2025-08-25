<?php

namespace Botble\FullPageCache\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearPageCacheCommand extends Command
{
    // Lệnh Artisan sẽ dùng
    protected $signature = 'cache:clear-pages';
    protected $description = 'Xoá toàn bộ Full Page Cache';

    public function handle()
    {
        $path = storage_path('fullpage-cache');
        if (File::exists($path)) {
            File::cleanDirectory($path);
            $this->info('Đã xoá toàn bộ Full Page Cache!');
        } else {
            $this->info('Không có cache để xoá.');
        }
    }
}
