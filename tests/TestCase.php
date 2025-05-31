<?php

namespace Refinephp\LaravelLogClarity\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Refinephp\LaravelLogClarity\LaravelLogClarityServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Tell Testbench which package ServiceProvider to load.
     * This ensures config(…) and everything else is bound.
     */
    protected function getPackageProviders($app): array
    {
        return [
            // Adjust this if your ServiceProvider class name is different
            LaravelLogClarityServiceProvider::class,
        ];
    }

    /**
     * (Optional) Define any environment setup/configuration overrides.
     */
    protected function defineEnvironment($app): void
    {
        // Example: force the "testing" environment to include our config settings.
        // You can override anything in config('log-clarity') here if you like:
        $app['config']->set('log-clarity.include_paths', ['tests/']);
        $app['config']->set('log-clarity.exclude_paths', ['vendor/']);
        $app['config']->set('log-clarity.max_stack_length', 5);
    }
}
