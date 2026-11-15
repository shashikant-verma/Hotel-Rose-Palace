<?php

namespace Database\Factories;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTypeFactory extends Factory
{
    protected $model = RoomType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word() . ' Room',
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(),
            'base_price' => $this->faker->numberBetween(2000, 10000),
            'max_occupancy' => $this->faker->numberBetween(1, 6),
            'max_adults' => $this->faker->numberBetween(1, 4),
            'max_children' => $this->faker->numberBetween(0, 2),
            'is_active' => true,
        ];
    }
}
