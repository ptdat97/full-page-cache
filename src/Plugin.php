<?php

namespace Botble\FullPageCache;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('Full Page Caches');
        Schema::dropIfExists('Full Page Caches_translations');
    }
}
