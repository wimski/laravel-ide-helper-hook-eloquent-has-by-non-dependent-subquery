<?php

declare(strict_types=1);

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDepedentSubquery\Tests\Integration;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDepedentSubquery\Hooks\EloquentHasByNonDepedentSubqueryHook;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDepedentSubquery\Providers\LaravelIdeHelperHookEloquentHasByNonDepedentSubqueryServiceProvider;

class LaravelIdeHelperHookPaperclipServiceProviderTest extends TestCase
{
    /**
     * @param Application $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelIdeHelperHookEloquentHasByNonDepedentSubqueryServiceProvider::class,
        ];
    }

    /**
     * @test
     */
    public function it_adds_the_hook_to_the_config(): void
    {
        static::assertContains(EloquentHasByNonDepedentSubqueryHook::class, config('ide-helper.model_hooks'));
    }
}
