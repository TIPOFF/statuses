<?php

namespace Tipoff\Statuses;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tipoff\Statuses\Statuses
 */
class StatusesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'statuses';
    }
}
