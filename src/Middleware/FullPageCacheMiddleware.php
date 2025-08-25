<?php

namespace Botble\FullPageCache\Middleware;

use Closure;

class FullPageCacheMiddleware
{
    public function handle($request, Closure $next)
    {
        // Các URL không được cache
        $excluded = ['cart', 'checkout', 'customer', 'admin'];

        foreach ($excluded as $keyword) {
            if ($request->is($keyword) || $request->is($keyword . '/*')) {
                // Bỏ qua cache, trả thẳng response
                return $next($request);
            }
        }

        // Folder cache
        $path = storage_path('fullpage-cache');
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        // Key cache dựa trên URL
        $key = md5($request->fullUrl());
        $file = $path . '/' . $key . '.html';

        // Nếu đã cache, trả thẳng file HTML
        if (file_exists($file)) {
            return response(file_get_contents($file));
        }

        // Render bình thường
        $response = $next($request);

        // Lưu cache nếu là HTML
        if ($response->status() === 200 &&
            str_contains($response->headers->get('content-type'), 'text/html')) {
            file_put_contents($file, $response->getContent());
        }

        return $response;
    }
}
