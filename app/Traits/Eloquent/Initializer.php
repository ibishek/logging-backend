<?php

use Illuminate\Database\Eloquent\Builder;

trait Initializer
{
    public static function initialize(): Builder
    {
        $builder = null;

        if (method_exists(static::class, 'initialize')) {
            $builder = static::initialize();
        } else {
            $builder = static::query();
        }

        $sortBy = request()->query('sort_boy');
        $sortOrder = request()->query('sort_order');
        $query = request()->query('query');

        return $builder;
    }
}
