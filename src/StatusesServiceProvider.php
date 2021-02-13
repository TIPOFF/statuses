<?php

declare(strict_types=1);

namespace Tipoff\Statuses;

use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\Statuses\Models\Status;
use Tipoff\Statuses\Policies\StatusPolicy;

class StatusesServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        parent::boot();
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('statuses')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        Gate::policy(Status::class, StatusPolicy::class);
    }
}
