<?php

declare(strict_types=1);

namespace Tipoff\Statuses;

use Tipoff\Statuses\Models\Status;
use Tipoff\Statuses\Policies\StatusPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class StatusesServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Statuses::class => StatusPolicy::class,
            ])
            ->name('statuses')
            ->hasConfigFile();
    }
}
