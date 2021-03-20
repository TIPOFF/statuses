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
        return [
            'status_id' => randomOrCreate(app('status')),
            'type' => get_class(app('status')),
            'statusable_type' => get_class(app('user')),
            'statusable_id' => randomOrCreate(app('user')),
            'creator_id' => randomOrCreate(app('user')),
        ];
    }
}
