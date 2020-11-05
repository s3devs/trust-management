<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
      return [
        'first_name'            => $this->faker->firstNameMale,
        'surname'               => $this->faker->lastName,
        'email'                 => $this->faker->unique()->safeEmail,
        'email_verified_at'     => now(),
        'password'              => Hash::make('password'),
        'remember_token'        => Str::random(10),
        'phone_number'          => '01924 280876',
        'mobile_number'         => '01924 280876',
        'calendar_color'        => '#ea1d75',
        'dob'                   => '1992-01-01',
        'gender'                => 'Male',
        'hourly_rate_standard'  => rand(12, 25),
        'hourly_rate_overtime'  => rand(12, 25),
        'home_address'          => $this->faker->address,
        'job_role'              => $this->faker->jobTitle,
        'created_by'            => 1,
        'updated_by'            => 1,
      ];
    }
}
