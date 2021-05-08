<?php

declare(strict_types=1);

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\Unit\Providers;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Foundation\Application;
use Mockery;
use Mockery\MockInterface;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Hooks\EloquentHasByNonDependentSubqueryHook;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Providers\LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProvider;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\Unit\AbstractUnitTest;

class LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProviderTest extends AbstractUnitTest
{
    /**
     * @var LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProvider
     */
    protected $provider;

    /**
     * @var Application|MockInterface
     */
    protected $app;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app      = Mockery::mock(Application::class);
        $this->provider = new LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProvider($this->app);
    }

    /**
     * @test
     */
    public function it_adds_the_hook_to_the_config(): void
    {
        /** @var Config|MockInterface $config */
        $config = Mockery::mock(Config::class)
            ->shouldReceive('get')
            ->with('ide-helper.model_hooks', [])
            ->andReturn([])
            ->getMock()
            ->shouldReceive('set')
            ->with('ide-helper.model_hooks', [EloquentHasByNonDependentSubqueryHook::class])
            ->getMock();

        $this->app->shouldReceive('isProduction')->andReturnFalse();
        $this->app->shouldReceive('get')->with('config')->andReturn($config);

        $this->provider->register();
    }

    /**
     * @test
     */
    public function it_does_not_add_the_hook_to_the_config_when_in_production(): void
    {
        $this->app->shouldReceive('isProduction')->andReturnTrue();
        $this->app->shouldNotReceive('get')->with('config');

        $this->provider->register();
    }
}
