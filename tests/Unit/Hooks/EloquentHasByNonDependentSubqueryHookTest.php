<?php

declare(strict_types=1);

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\Unit\Hooks;

use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Illuminate\Contracts\Config\Repository as Config;
use Mockery;
use Mockery\MockInterface;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Hooks\EloquentHasByNonDependentSubqueryHook;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\stubs\Models\TestModel;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\Unit\AbstractUnitTest;

class EloquentHasByNonDependentSubqueryHookTest extends AbstractUnitTest
{
    /**
     * @test
     */
    public function it_writes_methods_to_the_model(): void
    {
        /** @var ModelsCommand|MockInterface $command */
        $command = Mockery::mock(ModelsCommand::class)
            ->shouldReceive('option')->with('write-mixin')->andReturnFalse()->getMock()
            ->shouldReceive('option')->with('write')->andReturnTrue()->getMock();

        $this->commandShouldReceiveMethods($command, '\\Illuminate\\Database\\Eloquent\\Builder|TestModel');

        (new EloquentHasByNonDependentSubqueryHook($this->mockConfig()))
            ->run($command, new TestModel());
    }

    /**
     * @param ModelsCommand|MockInterface $command
     * @param string                      $type
     */
    protected function commandShouldReceiveMethods($command, string $type): void
    {
        $methods = [
            'doesntHaveByNonDependentSubquery',
            'hasByNonDependentSubquery',
            'orDoesntHaveByNonDependentSubquery',
            'orHasByNonDependentSubquery',
        ];

        foreach ($methods as $method) {
            $command
                ->shouldReceive('setMethod')
                ->with(
                    $method,
                    $type,
                    [
                        '$relationMethod',
                        '...$constraints',
                    ]
                );
        }
    }

    /**
     * @param bool $forceFqn
     * @return Config|MockInterface
     */
    protected function mockConfig(bool $forceFqn = false)
    {
        /** @var Config|MockInterface $config */
        $config = Mockery::mock(Config::class)
            ->shouldReceive('get')
            ->with('ide-helper.force_fqn', false)
            ->andReturn($forceFqn)
            ->getMock();

        return $config;
    }
}
