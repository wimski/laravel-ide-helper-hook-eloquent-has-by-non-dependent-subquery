<?php

declare(strict_types=1);

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\Integration;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Hooks\EloquentHasByNonDependentSubqueryHook;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Providers\LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProvider;

class LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProviderTest extends TestCase
{
    /**
     * @param Application $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProvider::class,
        ];
    }

    /**
     * @test
     */
    public function it_adds_the_hook_to_the_config(): void
    {
        static::assertContains(EloquentHasByNonDependentSubqueryHook::class, config('ide-helper.model_hooks'));
    }
}
