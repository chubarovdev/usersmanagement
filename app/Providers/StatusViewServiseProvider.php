<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StatusViewServiseProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() .  '/Helpers/StatusView.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
