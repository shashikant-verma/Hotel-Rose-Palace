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
            'reference_id' => SecurityService::generateReference(),
            'room_type_id' => RoomType::factory(),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->unique()->safeEmail(),
            'customer_phone' => $this->faker->phoneNumber(),
            'check_in_date' => $checkInDate->format('Y-m-d'),
            'check_out_date' => $checkOutDate->format('Y-m-d'),
            'num_adults' => $this->faker->numberBetween(1, 4),
            'num_children' => $this->faker->numberBetween(0, 2),
            'special_requests' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(['new', 'contacted', 'availability_confirmed', 'booking_confirmed', 'cancelled', 'closed']),
            'internal_notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
