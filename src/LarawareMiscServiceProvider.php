<?php

namespace Livelyworks\Laraware;

use Illuminate\Support\ServiceProvider;

class LarawareMiscServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        require_once __DIR__ . '/helpers/misc.php';
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Optional: publish configs, views, routes etc.
    }
}
