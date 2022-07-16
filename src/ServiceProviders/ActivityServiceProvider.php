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

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations/');
    }
}
