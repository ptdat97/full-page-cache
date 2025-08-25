<?php

namespace Botble\FullPageCache\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\File;

class FullPageCacheMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->is('admin/*') || $request->is('cart') || $request->is('checkout')) {
            return $next($request);
        }

        $key = md5($request->fullUrl());
        $path = public_path('cache/fullpage/' . $key . '.html');

        if (File::exists($path)) {
            return response(File::get($path));
        }

        $response = $next($request);

        if ($response->status() === 200 && $response->headers->get('Content-Type') === 'text/html; charset=UTF-8') {
            File::ensureDirectoryExists(public_path('cache/fullpage'));
            File::put($path, $response->getContent());
        }

        return $response;
    }
}
