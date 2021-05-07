<?php

declare(strict_types=1);

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Hooks;

use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Barryvdh\LaravelIdeHelper\Contracts\ModelHookInterface;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\ContextFactory;
use ReflectionClass;
use ReflectionObject;
use function Safe\array_flip;

class EloquentHasByNonDependentSubqueryHook implements ModelHookInterface
{
    protected const METHODS = [
        'doesntHaveByNonDependentSubquery',
        'hasByNonDependentSubquery',
        'orDoesntHaveByNonDependentSubquery',
        'orHasByNonDependentSubquery',
    ];

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var bool
     */
    protected $writeToModel;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function run(ModelsCommand $command, Model $model): void
    {
        $this->writeToModel = ($command->option('write-mixin') || $command->option('write'));

        $modelName = $this->getClassNameInDestinationFile($model, get_class($model));
        $builder   = $this->getClassNameInDestinationFile($model, Builder::class);

        foreach (static::METHODS as $method) {
            $command->setMethod(
                $method,
                $builder . '|' . $modelName,
                [
                    '$relationMethod',
                    '...$constraints',
                ]
            );
        }
    }

    /*
    |
    | The following methods are copied directly
    | from the models command.
    | Ideally the getClassNameInDestinationFile method
    | should be public to avoid duplication.
    |
    */

    protected function getClassNameInDestinationFile(object $model, string $className): string
    {
        $reflection = new ReflectionObject($model);

        $className = trim($className, '\\');
        $classIsNotInExternalFile = $reflection->getName() !== $className;
        $forceFQCN = $this->config->get('ide-helper.force_fqn', false);

        if ((! $this->writeToModel && $classIsNotInExternalFile) || $forceFQCN) {
            return '\\' . $className;
        }

        $usedClassNames = $this->getUsedClassNames($reflection);
        return $usedClassNames[$className] ?? ('\\' . $className);
    }

    /**
     * @param ReflectionClass $reflection
     * @return string[]
     */
    protected function getUsedClassNames(ReflectionClass $reflection): array
    {
        $namespaceAliases = array_flip((new ContextFactory())->createFromReflector($reflection)->getNamespaceAliases());
        $namespaceAliases[$reflection->getName()] = $reflection->getShortName();

        return $namespaceAliases;
    }
}
