<?php

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Providers;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\ServiceProvider;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Hooks\EloquentHasByNonDependentSubqueryHook;

class LaravelIdeHelperHookEloquentHasByNonDependentSubqueryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->isProduction()) {
            return;
        }

        /** @var Config $config */
        $config = $this->app->get('config');

        $config->set('ide-helper.model_hooks', array_merge([
            EloquentHasByNonDependentSubqueryHook::class,
        ], $config->get('ide-helper.model_hooks', [])));
    }
}
