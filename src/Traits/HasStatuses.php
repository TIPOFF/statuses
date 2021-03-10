<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Traits;

use Illuminate\Support\Collection;
use Tipoff\Statuses\Exceptions\UnknownStatusException;
use Tipoff\Statuses\Models\Status;
use Tipoff\Statuses\Models\Statusable;

/**
 * @property Collection statusables
 */
trait HasStatuses
{
    // When true, new statuses will be added automatically on first use
    // When false, exception occurs if unknown status value is used
    protected bool $dynamicStatusCreation = false;

    public function getStatus(?string $type = null): ?Status
    {
        $statusable = $this->getStatusableByType($type ?? get_class($this));

        return $statusable ? $statusable->status : null;
    }

    public function setStatus(string $name, ?string $type = null): ?Status
    {
        $type = $type ?? get_class($this);
        $statusable = $this->getStatusableByType($type);

        $status = $this->getStatusByName($name, $type);

        if (! $statusable) {
            $statusable = new Statusable();
            $statusable->type = $type;
            $statusable->statusable()->associate($this);
        }

        $statusable->status()->associate($status)->save();
        $this->load('statusables');

        return $statusable->status;
    }

    public function statusables()
    {
        return $this->morphMany(Statusable::class, 'statusable');
    }

    private function getStatusableByType(string $type): ?Statusable
    {
        return $this->statusables()->where('type', '=', $type)->first();
    }

    private function getStatusByName(string $name, string $type): Status
    {
        if ($this->dynamicStatusCreation) {
            return Status::createStatus($type, $name);
        }

        if ($status = Status::findStatus($type, $name)) {
            return $status;
        }

        throw new UnknownStatusException($type, $name);
    }
}
