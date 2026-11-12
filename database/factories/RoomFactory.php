<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'room_type_id' => RoomType::factory(),
            'room_number' => $this->faker->unique()->numerify('R###'),
            'floor' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['available', 'occupied', 'maintenance']),
        ];
    }
}
