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
            'name' => $this->faker->word() . ' Room',
            'description' => $this->faker->paragraph(),
            'base_price' => $this->faker->numberBetween(2000, 10000),
            'max_guests' => $this->faker->numberBetween(1, 6),
        ];
    }
}
