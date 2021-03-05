<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Tests\Support\Providers;

use Tipoff\Statuses\Nova\Status;
use Tipoff\TestSupport\Providers\BaseNovaPackageServiceProvider;

class NovaPackageServiceProvider extends BaseNovaPackageServiceProvider
{
    public static array $packageResources = [
        Status::class,
    ];
}
