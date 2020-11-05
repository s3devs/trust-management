<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private $adminRole;
    private $userRole;
    private $staffRole;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($prod = false)
    {
        $this->adminRole = Role::where('slug', 'admin')->first();
        $this->userRole = Role::where('slug', 'user')->first();
        $this->staffRole = Role::where('slug', 'staff')->first();

        if ($prod) {
            $this->prod();
        } else {
            $this->dev();
        }
    }
    /**
     * Run the production database seeds.
     *
     * @return void
     */
    private function prod()
    {
        $admin = User::create([
            'first_name'            => 'Go',
            'surname'               => 'Media',
            'email'                 => 'hello@gomedia.co',
            'email_verified_at'     => now(),
            'password'              => Hash::make('Gis0ra$$;'),
            'remember_token'        => Str::random(10),
            'phone_number'          => '01924 280876',
            'mobile_number'         => '01924 280876',
            'calendar_color'        => '#ea1d75',
            'dob'                   => '1992-01-01',
            'hourly_rate_standard'  => '12.00',
            'hourly_rate_overtime'  => '20.00',
            'gender'                => 'Male',
            'home_address'          => '1C The Gateway, Fryersway, Silkwood Park, Wakefield, WF5 9TJ',
            'job_role'              => 'Web Developer',
            'created_by'            => 1,
            'updated_by'            => 1,
        ]);

        $admin->roles()->attach($this->adminRole);
    }

    /**
     * Run the development only database seeds.
     *
     * @return void
     */
    private function dev()
    {
        $user = User::create([
            'first_name'            => 'General',
            'surname'               => 'Member',
            'email'                 => 'user@gomedia.co',
            'email_verified_at'     => now(),
            'password'              => Hash::make('9yeKweRyRho7'),
            'remember_token'        => Str::random(10),
            'phone_number'          => '01924 280876',
            'mobile_number'         => '01924 280876',
            'calendar_color'        => '#ea1d75',
            'dob'                   => '1992-01-01',
            'gender'                => 'Male',
            'home_address'          => '1C The Gateway, Fryersway, Silkwood Park, Wakefield, WF5 9TJ',
            'job_role'              => 'General User',
            'hourly_rate_standard'  => '12.00',
            'hourly_rate_overtime'  => '20.00',
            'created_by'            => 1,
            'updated_by'            => 1,
        ]);

        $staff = User::create([
            'first_name'            => 'Staff',
            'surname'               => 'Member',
            'email'                 => 'staff@gomedia.co',
            'email_verified_at'     => now(),
            'password'              => Hash::make('9yeKweRyRho7'),
            'remember_token'        => Str::random(10),
            'phone_number'          => '01924 280876',
            'mobile_number'         => '01924 280876',
            'calendar_color'        => '#ea1d75',
            'dob'                   => '1992-01-01',
            'gender'                => 'Male',
            'home_address'          => '1C The Gateway, Fryersway, Silkwood Park, Wakefield, WF5 9TJ',
            'job_role'              => 'General Staff',
            'hourly_rate_standard'  => '12.00',
            'hourly_rate_overtime'  => '20.00',
            'created_by'            => 1,
            'updated_by'            => 1,
        ]);

        $user->roles()->attach($this->userRole);
        $staff->roles()->attach($this->staffRole);
    }
}
