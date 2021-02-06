<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Tipoff\Forms\Models\Status;

class StatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Status::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $word1 = $this->faker->unique->word;
        $word2 = $this->faker->word;

        return [
            'slug' => Str::slug(rand(1, 1000).'-'.$word1.'-'.$word2),
            'name' => $word1.' '.$word2,
            'applies_to' => $this->faker->randomElement(['order', 'slot', 'game', 'invoice', 'payment']),
            'note' => $this->faker->sentences(1, true),
        ];
    }
}
