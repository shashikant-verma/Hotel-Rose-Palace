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
        $roomType = RoomType::factory();
        
        return [
            'room_type_id' => $roomType,
            'room_number' => $this->faker->unique()->numerify('R###'),
            'floor' => $this->faker->numberBetween(1, 10),
            'current_price' => $this->faker->numberBetween(3000, 10000),
            'is_available' => true,
            'status' => $this->faker->randomElement(['available', 'booked', 'maintenance']),
        ];
    }
}
