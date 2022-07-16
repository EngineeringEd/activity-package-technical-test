<?php

declare(strict_types=1);

namespace Activity\Tests\Utils;

use Activity\ServiceProviders\ActivityServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [ActivityServiceProvider::class];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadLaravelMigrations();
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('title');
            $table->string('body');
            $table->timestamps();
        });
    }
}
