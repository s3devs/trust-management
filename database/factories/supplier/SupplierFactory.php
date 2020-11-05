<?php

namespace Database\Factories\Supplier;

use App\Models\Supplier\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'company_name' => $this->faker->company,
          'label' => $this->faker->firstNameMale,
          'account_manager_id' => rand(1,100),
          'general_contact_number' => $this->faker->phoneNumber,
          'general_email_address' => $this->faker->unique()->safeEmail,
          'status' => 'On Stop'
        ];
    }
}
