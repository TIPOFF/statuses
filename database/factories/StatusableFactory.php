<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Tipoff\Authorization\Models\User;
use Tipoff\Statuses\Models\Status;
use Tipoff\Statuses\Models\Statusable;

class StatusableFactory extends Factory
{
    protected $model = Statusable::class;

    public function definition()
    {
        $statusable = User::factory()->create();

        return [
            'status_id' => randomOrCreate(Status::class),
            'statusable_type' => get_class($statusable),
            'statusable_id' => $statusable->id,
            'creator_id' => randomOrCreate(app('user')),
        ];
    }
}
