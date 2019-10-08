<?php

namespace MrJohnMain\FragmentCache;

use Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class FragmentCacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Kernel $kernel
     */
    public function boot(Kernel $kernel)
    {
        Blade::directive('cache', function ($expression) {
            return "things";
        });

        Blade::directive('endcache', function () {
            return "<?php endif; echo app('MrJohnMain\FragmentCache\BladeDirective')->tearDown() ?>";
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(BladeDirective::class);
    }
}

