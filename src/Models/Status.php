<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class Status extends BaseModel
{
    use HasPackageFactory;

    protected $casts = [];
}
