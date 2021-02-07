<?php

namespace Tipoff\Statuses\Models;

use Illuminate\Database\Eloquent\Model;
use Tipoff\Support\Traits\HasPackageFactory;

class Status extends Model
{
    use HasPackageFactory;

    protected $guarded = ['id'];
    protected $casts = [];
}
