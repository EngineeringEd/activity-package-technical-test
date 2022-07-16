<?php

declare(strict_types=1);

namespace Activity\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class ActivityServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ]);
        /**
         * Commented this out so the migration isn't loaded when service provider is booted
         * This gives the developer control over the migration so they can make changes without
         * having to run php artisn migrate:fresh.
         */
//        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
    }
}
