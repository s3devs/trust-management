<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($prod = false)
    {
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
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'admin',
        ]);
        $userRole = Role::create([
            'name' => 'User',
            'slug' => 'user',
            'description' => 'admin',
        ]);
        $staffRole = Role::create([
            'name' => 'Staff',
            'slug' => 'staff',
            'description' => 'admin',
        ]);
    }

    /**
     * Run the development only database seeds.
     *
     * @return void
     */
    private function dev()
    {
    }
    
}
