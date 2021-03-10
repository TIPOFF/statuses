<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Traits;

use Tipoff\Statuses\Exceptions\UnknownStatusException;
use Tipoff\Statuses\Models\Status;
use Tipoff\Statuses\Models\Statusable;

/**
 * @property Statusable statusable
 */
trait HasStatuses
{
    // When true, new statuses will be added automatically on first use
    // When false, exception occurs if unknown status value is used
    protected bool $dynamicStatusCreation = false;

    // Assumes models can only have a single type of status
    public function statusType(): string
    {
        // Default to using full class name as type
        return get_class($this);
    }

    public function status(?string $name = null): ?Status
    {
        /** @var Statusable|null $statusable */
        $statusable = $this->statusable;

        if ($name) {
            $status = $this->getStatusByName($name);

            if (! $statusable) {
                $statusable = new Statusable();
                $statusable->statusable()->associate($this);
            }

            $statusable->status()->associate($status)->save();
            $this->load('statusable');
        }

        return $statusable ? $statusable->status : null;
    }

    public function statusable()
    {
        return $this->morphOne(Statusable::class, 'statusable');
    }

    private function getStatusByName(string $name): Status
    {
        if ($this->dynamicStatusCreation) {
            return Status::createStatus($this->statusType(), $name);
        }

        if ($status = Status::findStatus($this->statusType(), $name)) {
            return $status;
        }

        throw new UnknownStatusException($this->statusType(), $name);
    }
}
