<?php

namespace Refinephp\LaravelLogClarity\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array cleanThrowable(\Throwable $exception)
 *
 * @see \Refinephp\LaravelLogClarity\Services\LogClarityService
 */
class LaravelLogClarity extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-log-clarity';
        // This key should match what you bind in a Service Container or in your service provider.
    }
}
