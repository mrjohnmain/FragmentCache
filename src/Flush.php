<?php

namespace MrJohnMain\FragmentCache;

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
        Cache::tags('views')->flush();

        return $next($request);
    }
}

