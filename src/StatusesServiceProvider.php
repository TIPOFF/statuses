<?php

namespace Tipoff\Statuses;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\Statuses\Commands\StatusesCommand;

class StatusesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('statuses')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_statuses_table')
            ->hasCommand(StatusesCommand::class);
    }
}
