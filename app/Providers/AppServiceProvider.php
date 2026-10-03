<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Listener wiring lives entirely in app/Listeners via Laravel's default
     * event auto-discovery (each listener's handle(SomeEvent $event) method
     * signature is enough) — do not also register them here with
     * Event::listen(), or every dispatch fires the listener twice.
     */
    public function boot(): void
    {
        //
    }
}
