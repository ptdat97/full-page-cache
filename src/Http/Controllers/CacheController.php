<?php

namespace Botble\FullPageCache\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class CacheController extends Controller
{
    public function clear()
    {
        File::cleanDirectory(public_path('cache/fullpage'));
        return redirect()->back()->with('status', 'Full Page Cache cleared!');
    }
}
