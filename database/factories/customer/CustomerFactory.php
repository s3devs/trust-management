<?php

namespace Database\Factories\Customer;

use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'type' => 'Company',
          'label' => $this->faker->firstNameMale,
          'general_contact_number' => $this->faker->phoneNumber,
          'general_email_address' => $this->faker->unique()->safeEmail,
          'referral_source_id' => rand(1,6),
          'status' => 'On Stop'
        ];
    }
}
