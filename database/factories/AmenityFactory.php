<?php

namespace Database\Factories;

use App\Models\Amenity;
use Illuminate\Database\Eloquent\Factories\Factory;

class AmenityFactory extends Factory
{
    protected $model = Amenity::class;

    public function definition(): array
    {
        $icons = ['fas fa-wifi', 'fas fa-parking', 'fas fa-spa', 'fas fa-swimmer', 'fas fa-utensils', 'fas fa-tv'];

        return [
            'name' => $this->faker->unique()->word(),
            'icon_class' => $this->faker->randomElement($icons),
            'description' => $this->faker->sentence(),
        ];
    }
}
