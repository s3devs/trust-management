<?php

namespace Database\Factories\Customer;

use App\Models\Customer\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'label' => $this->faker->firstName,
          'address_line_1' => $this->faker->address,
          'address_city' => $this->faker->city,
          'address_county' => $this->faker->state,
          'address_postcode' => $this->faker->postcode,
          'address_country' => $this->faker->country,
          'default' => rand(0,1),
          'accounts' => rand(0,1),
        ];
    }
}
