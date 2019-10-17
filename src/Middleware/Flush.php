<?php

namespace MrJohnMain\FragmentCache\Middleware;

use Illuminate\Support\Facades\Cache;

class Flush
{
    /**
     * Handle the request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     */
    public function handle($request, $next)
    {
        Cache::flush();

        return $next($request);
    }
}

