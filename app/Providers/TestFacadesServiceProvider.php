<?php

namespace App\Providers;

use App;
use App\Services\TestService;
use Illuminate\Support\ServiceProvider;

class TestFacadesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
     
        $this->app->bind('test', TestService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind('test', TestService::class);
    }
}
