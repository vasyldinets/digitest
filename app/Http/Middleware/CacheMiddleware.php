<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class CacheMiddleware
{
    public function handle($request, Closure $next) {
        if($request->method() == "GET"){
            $key = $this->makeCacheKey($request->fullUrl());
            if (Cache::has($key)) {
                return response(Cache::get($key));
            }
        }
        return $next($request);
    }

    public function terminate($request, $response) {
        if($request->method() == "GET") {
            $key = $this->makeCacheKey($request->fullUrl());
            if (!Cache::has($key)) {
                Cache::put($key, $response->getContent(), env('CACHE_TIME', 60));
            }
        }
    }

    protected function makeCacheKey($url) {
        return 'route_' . str_slug($url);
    }
}
