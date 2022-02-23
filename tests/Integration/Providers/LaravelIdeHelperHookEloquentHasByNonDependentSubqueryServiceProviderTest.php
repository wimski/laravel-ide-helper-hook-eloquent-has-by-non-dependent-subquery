<?php

declare(strict_types=1);

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\Integration\Providers;

use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Hooks\EloquentHasByNonDependentSubqueryHook;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\Integration\AbstractIntegrationTest;
use function config;

class LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProviderTest extends AbstractIntegrationTest
{
    /**
     * @test
     */
    public function it_adds_the_hook_to_the_config(): void
    {
        /** @var string[] $modelHooks */
        $modelHooks = config('ide-helper.model_hooks');

        static::assertContains(EloquentHasByNonDependentSubqueryHook::class, $modelHooks);
    }
}
