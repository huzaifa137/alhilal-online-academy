<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Belt-and-suspenders: this file is also declared under
        // composer.json's autoload.files, but that only takes effect
        // after `composer dump-autoload` runs. Requiring it here too
        // means the ar()/ar_level_label()/ar_section_label() helpers
        // work immediately, even before composer regenerates its
        // autoload cache.
        if (!function_exists('ar')) {
            require_once app_path('Support/helpers.php');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}