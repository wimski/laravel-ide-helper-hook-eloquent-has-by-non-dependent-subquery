<?php

declare(strict_types=1);

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\Integration;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Providers\LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProvider;

abstract class AbstractIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param Application $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            IdeHelperServiceProvider::class,
            LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom($this->getStubsPath('database' . DIRECTORY_SEPARATOR . 'migrations'));
    }

    protected function getStubsPath(string $path): string
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . $path;
    }
}
