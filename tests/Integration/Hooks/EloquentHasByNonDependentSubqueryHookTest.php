<?php

declare(strict_types=1);

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\Integration\Hooks;

use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Symfony\Component\Console\Tester\CommandTester;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Hooks\EloquentHasByNonDependentSubqueryHook;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\Integration\AbstractIntegrationTest;

class EloquentHasByNonDependentSubqueryHookTest extends AbstractIntegrationTest
{
    use MockeryPHPUnitIntegration;

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('ide-helper', [
            'model_locations' => [
                '/../../../../tests/stubs/Models',
            ],
            'model_hooks' => [
                EloquentHasByNonDependentSubqueryHook::class,
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_writes_methods_to_the_model(): void
    {
        $actualContent = null;

        $this->mockFilesystem($this->getStubsPath('Models' . DIRECTORY_SEPARATOR . 'TestModel.php'), $actualContent);

        $command = $this->app->make(ModelsCommand::class);

        $tester = $this->runCommand($command, [
            '--write' => true,
        ]);

        $this->assertSame(0, $tester->getStatusCode());
        $this->assertStringContainsString('Written new phpDocBlock to', $tester->getDisplay());

        $expectedContent = <<<'PHP'
<?php

declare(strict_types=1);

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\stubs\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\stubs\Models\TestModel
 *
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|TestModel doesntHaveByNonDependentSubquery($relationMethod, ...$constraints)
 * @method static \Illuminate\Database\Eloquent\Builder|TestModel hasByNonDependentSubquery($relationMethod, ...$constraints)
 * @method static \Illuminate\Database\Eloquent\Builder|TestModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestModel orDoesntHaveByNonDependentSubquery($relationMethod, ...$constraints)
 * @method static \Illuminate\Database\Eloquent\Builder|TestModel orHasByNonDependentSubquery($relationMethod, ...$constraints)
 * @method static \Illuminate\Database\Eloquent\Builder|TestModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|TestModel whereId($value)
 * @mixin \Eloquent
 */
class TestModel extends Model
{
}

PHP;

        $this->assertSame($expectedContent, $actualContent);
    }

    /**
     * @param Command              $command
     * @param array<string, mixed> $arguments
     * @param array                $interactiveInput
     * @return CommandTester
     */
    protected function runCommand(Command $command, array $arguments = [], array $interactiveInput = []): CommandTester
    {
        $this->withoutMockingConsoleOutput();

        $command->setLaravel($this->app);

        $tester = new CommandTester($command);
        $tester->setInputs($interactiveInput);
        $tester->execute($arguments);

        return $tester;
    }

    protected function mockFilesystem(string $modelPath, ?string &$content): void
    {
        /** @var Filesystem|MockInterface $filesystem */
        $filesystem = Mockery::mock(Filesystem::class)
            ->shouldReceive('get')
            ->andReturn(file_get_contents($modelPath))
            ->once()
            ->getMock()
            ->shouldReceive('put')
            ->with(
                Mockery::any(),
                Mockery::capture($content)
            )
            ->andReturn(1)
            ->once()
            ->getMock();

        $this->instance(Filesystem::class, $filesystem);
    }
}
