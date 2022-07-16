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
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ]);
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'activity-package');

        /**
         * Keeping this here for test, but the migration will load on service provider boot.
         * If we want the developer using this package to be able to change the migration without
         * using php artisan migrate:fresh, we should remove this.
         */
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations/');
    }
}
