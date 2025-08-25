<?php

namespace Botble\FullPageCache\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearPageCacheCommand extends Command
{
    /**
     * Tên command để gọi trong terminal
     *
     * @var string
     */
    protected $signature = 'fullpagecache:clear';

    /**
     * Mô tả command
     *
     * @var string
     */
    protected $description = 'Clear all Full Page Cache files';

    /**
     * Thực thi command
     */
    public function handle(): int
    {
        $path = storage_path('fullpage-cache');

        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
            $this->info('✅ Full Page Cache cleared successfully!');
        } else {
            $this->info('ℹ️ No full page cache found to clear.');
        }

        return self::SUCCESS;
    }
}
