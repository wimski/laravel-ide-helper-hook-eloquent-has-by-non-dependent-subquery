<?php

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDepedentSubquery\Providers;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\ServiceProvider;
use Wimski\LaravelIdeHelperHookEloquentHasByNonDepedentSubquery\Hooks\EloquentHasByNonDepedentSubqueryHook;

class LaravelIdeHelperHookEloquentHasByNonDepedentSubqueryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->isProduction()) {
            return;
        }

        /** @var Config $config */
        $config = $this->app->get('config');

        $config->set('ide-helper.model_hooks', array_merge([
            EloquentHasByNonDepedentSubqueryHook::class,
        ], $config->get('ide-helper.model_hooks', [])));
    }
}
