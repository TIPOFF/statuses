<?php

declare(strict_types=1);

namespace Tipoff\Statuses;

use Tipoff\Statuses\Models\Status;
use Tipoff\Statuses\Models\StatusRecord;
use Tipoff\Statuses\Policies\StatusPolicy;
use Tipoff\Statuses\Policies\StatusRecordPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class StatusesServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Status::class => StatusPolicy::class,
                StatusRecord::class => StatusRecordPolicy::class,
            ])
            ->hasNovaResources([
                \Tipoff\Statuses\Nova\Status::class,
                \Tipoff\Statuses\Nova\StatusRecord::class,
            ])
            ->name('statuses')
            ->hasConfigFile();
    }
}
