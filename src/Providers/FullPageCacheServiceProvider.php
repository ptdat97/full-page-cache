<?php

namespace Botble\FullPageCache\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Botble\Base\Facades\DashboardMenu;
use Botble\FullPageCache\Console\ClearPageCacheCommand;

class FullPageCacheServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Đăng ký command Artisan
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearPageCacheCommand::class,
            ]);
        }
    }

    public function boot()
    {
        // Middleware cache full page
        $this->app['router']->pushMiddlewareToGroup('web', \Botble\FullPageCache\Middleware\FullPageCacheMiddleware::class);

        // Tự động xóa cache khi bài viết/sản phẩm được thay đổi
        Event::listen([
            'eloquent.saved: Botble\Blog\Models\Post',
            'eloquent.saved: Botble\Ecommerce\Models\Product',
            'eloquent.deleted: Botble\Blog\Models\Post',
            'eloquent.deleted: Botble\Ecommerce\Models\Product',
        ], function () {
            $this->clearCache();
        });

        // Route admin để clear cache thủ công
        $adminPrefix = config('core.base.general.admin_dir', 'admin');
        $this->app['router']->group([
            'prefix' => $adminPrefix,
            'middleware' => ['web', 'auth'],
        ], function () {
            $this->app['router']->get('fullpagecache/clear', function () {
                $this->clearCache();
                return redirect()->back()->with('success_msg', 'All cache has been cleared!');
            })->name('fullpagecache.clear');
        });

        // Thêm menu trên backend


        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::registerItem([
                'id'        => 'full-page-cache-parent',
                'priority'  => 1,
                'parent_id' => null,
                'name'      => 'Full Page Cache',
                'icon'      => 'fas fa-database',
            ]);

                    DashboardMenu::registerItem([
                'id'         => 'full-page-cache',
                'priority'   => 1,
                'parent_id'  => 'full-page-cache-parent',
                'name'       => 'Clear Cache',
                'icon'       => 'fas fa-database',
                'url'        => url(config('core.base.general.admin_dir', 'admin') . '/fullpagecache/clear'),
                'permissions'=> [],
            ]);
        });



    }

    /**
     * Xóa toàn bộ cache.
     */
    public function clearCache()
    {
        $path = storage_path('fullpage-cache');
        if (File::exists($path)) {
            File::cleanDirectory($path);
        }
    }
}
