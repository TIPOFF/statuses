<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Traits;

use Illuminate\Support\Collection;
use Tipoff\Statuses\Exceptions\UnknownStatusException;
use Tipoff\Statuses\Models\Status;
use Tipoff\Statuses\Models\StatusRecord;

/**
 * @property Collection statusables
 */
trait HasStatuses
{
    // When true, new statuses will be added automatically on first use
    // When false, exception occurs if unknown status value is used
    protected bool $dynamicStatusCreation = false;

    public function getStatusHistory(?string $type = null): Collection
    {
        return $this->statusRecords()
            ->where('type', '=', $type ?? get_class($this))
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getStatus(?string $type = null): ?Status
    {
        $statusRecord = $this->getStatusHistory($type)->first();

        return $statusRecord ? $statusRecord->status : null;
    }

    public function setStatus(string $name, ?string $type = null): Status
    {
        $type = $type ?? get_class($this);

        $status = $this->getStatusByName($name, $type);

        // Check if desired status already set
        if ($currentStatus = $this->getStatus($type)) {
            if ($currentStatus->id === $status->id) {
                return $currentStatus;
            }
        }

        // Set status always creates new record, leaving full history behind
        $statusable = new StatusRecord();
        $statusable->type = $type;
        $statusable->statusable()->associate($this);

        $statusable->status()->associate($status)->save();
        $this->load('statusRecords');

        return $statusable->status;
    }

    public function statusRecords()
    {
        return $this->morphMany(StatusRecord::class, 'statusable');
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
