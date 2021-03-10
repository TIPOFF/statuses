<?php

declare(strict_types=1);

namespace Tipoff\Statuses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Tipoff\Statuses\Models\Status;

class StatusFactory extends Factory
{
    protected $model = Status::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['order', 'slot', 'game', 'invoice', 'payment']);
        $words = $this->faker->unique()->words(2, true);

        return [
            'name' => $words,
            'type' => $type,
            'note' => $this->faker->optional()->sentences(1, true),
        ];
    }
}
