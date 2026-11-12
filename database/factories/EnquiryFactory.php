<?php

namespace Database\Factories;

use App\Models\Enquiry;
use App\Models\RoomType;
use App\Services\SecurityService;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnquiryFactory extends Factory
{
    protected $model = Enquiry::class;

    public function definition(): array
    {
        $checkInDate = $this->faker->dateTimeBetween('+1 day', '+30 days');
        $checkOutDate = (clone $checkInDate)->modify('+3 days');

        return [
            'room_type_id' => RoomType::factory(),
            'guest_name' => $this->faker->name(),
            'guest_email' => $this->faker->unique()->safeEmail(),
            'guest_phone' => $this->faker->phoneNumber(),
            'check_in_date' => $checkInDate->format('Y-m-d'),
            'check_out_date' => $checkOutDate->format('Y-m-d'),
            'number_of_guests' => $this->faker->numberBetween(1, 4),
            'message' => $this->faker->optional()->sentence(),
            'reference_number' => SecurityService::generateReference(),
            'status' => $this->faker->randomElement(['new', 'contacted', 'confirmed', 'booked', 'cancelled']),
            'admin_notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
