<?php

namespace Database\Factories\Supplier;

use App\Models\Supplier\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'label' => $this->faker->firstName,
          'first_name' => $this->faker->firstName,
          'surname' => $this->faker->lastName,
          'role' => $this->faker->jobTitle,
          'email_address' => $this->faker->companyEmail,
          'contact_number' => $this->faker->phoneNumber,
          'default' => rand(0,1),
          'accounts' => rand(0,1),
        ];
    }
}
