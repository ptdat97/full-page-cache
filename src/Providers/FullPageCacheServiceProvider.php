<?php

namespace Botble\FullPageCache\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;
use Botble\FullPageCache\Models\FullPageCache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Botble\FullPageCache\Console\ClearPageCacheCommand;

class FullPageCacheServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/full-page-cache')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations();
            
            if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
                \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(FullPageCache::class, [
                    'name',
                ]);
            }           
            
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
                'icon'       => 'ti ti-box',
                'url'        => url(config('core.base.general.admin_dir', 'admin') . '/fullpagecache/clear'),
                'permissions'=> [],
            ]);
        });
    
    
    

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
    }
    
    public function register(): void
{
    $this->setNamespace('plugins/full-page-cache')
        ->loadHelpers();

    if ($this->app->runningInConsole()) {
        $this->commands([
            \Botble\FullPageCache\Console\ClearPageCacheCommand::class,
        ]);
    }
}


    protected function clearCache(): void
{
    $path = storage_path('fullpage-cache');
    if (File::isDirectory($path)) {
        File::deleteDirectory($path);
    }
}

}
