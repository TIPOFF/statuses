<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Enum;

use MabeEnum\Enum;

/**
 * @method static StatusType BOOKING()
 * @method static StatusType CONTACT()
 * @method static StatusType ORDER()
 * @psalm-immutable
 */
class StatusType extends Enum
{
    const BOOKING = 'booking';
    const CONTACT = 'contact';
    const ORDER = 'order';
}
