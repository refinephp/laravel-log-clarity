<?php

namespace Refinephp\LaravelLogClarity;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelLogClarityServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This method is called by PackageServiceProvider when registering your package.
         * The “$package” object allows you to:
         *  - set the package name
         *  - register a config file
         *  - register commands
         *  - register migrations
         *  - register routes
         */

        $package
            ->name('laravel-log-clarity')
            // Will look for config/log-clarity.php
            ->hasConfigFile();
        //->hasViews()          // No views needed for this package
        //->hasMigration('create_log_clarity_table') // If you ever need custom migrations
        //->hasCommand(LogClarityCommand::class)     // If you add any Artisan commands
        //->hasRoute('web.php');   // If you need to load routes
    }

    public function packageBooted(): void
    {
        // If there’s any boot-time logic (e.g., setting up custom log channels),
        // you can place it here.
    }

    public function packageRegistered(): void
    {
        // Bind the LogClarityService to the container under the key "log-clarity"
        $this->app->singleton('log-clarity', function ($app) {
            return new \Refinephp\LaravelLogClarity\Services\LogClarityService();
        });
    }
}
