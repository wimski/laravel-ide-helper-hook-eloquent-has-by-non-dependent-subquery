<?php

declare(strict_types=1);

namespace Wimski\LaravelIdeHelperHookEloquentHasByNonDependentSubquery\Tests\stubs\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TestModelWithBuilder extends Model
{
    protected $table = 'test_models';

    public function scopeFoo(Builder $query): Builder
    {
        return $query;
    }
}
