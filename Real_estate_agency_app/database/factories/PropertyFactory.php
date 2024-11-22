<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the model that this factory is for.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['House', 'Apartment']),
            'address' => $this->faker->address,
            'size' => $this->faker->numberBetween(500, 3000), // square feet
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'latitude' => $this->faker->latitude(-90, 90),
            'longitude' => $this->faker->longitude(-180, 180),
            'price' => $this->faker->randomFloat(2, 50000, 1000000), // Random price
        ];
    }
}
