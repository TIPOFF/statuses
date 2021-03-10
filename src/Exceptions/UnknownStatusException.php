<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Exceptions;

use Throwable;

class UnknownStatusException extends \InvalidArgumentException implements StatusException
{
    public function __construct(string $type, string $name, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Unknown status value '{$name}' for status type {$type}", $code, $previous);
    }
}
