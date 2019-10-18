<?php

namespace MrJohnMain\FragmentCache;

use Illuminate\Support\Facades\Blade;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class FragmentCacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Kernel $kernel
     */
    public function boot(Kernel $kernel)
    {
        Blade::directive('cache', function ($key_data) {
            return "<?php if (! app('MrJohnMain\FragmentCache\Directive')->setUp({$key_data})) : ?>";
        });

        Blade::directive('endcache', function () {
            return "<?php endif; echo app('MrJohnMain\FragmentCache\Directive')->tearDown() ?>";
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(Directive::class);
    }
}

