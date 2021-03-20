<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Statuses\Models\StatusRecord;

class StatusRecordFactory extends Factory
{
    protected $model = StatusRecord::class;

    public function definition()
    {
        $statusable = randomOrCreate(app('user'));
        $status = randomOrCreate(app('status'));

        return [
            'status_id' => $status,
            'type' => $status->type,
            'statusable_type' => get_class($statusable),
            'statusable_id' => $statusable->id,
            'creator_id' => randomOrCreate(app('user')),
        ];
    }
}
