<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
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

    private function prod()
    {
        Permission::create([
            'module' => 'Customer',
            'name' => 'Store',
            'slug' => 'store-customer',
        ]);

        Permission::create([
            'module' => 'Customer',
            'name' => 'Show',
            'slug' => 'show-customer',
        ]);

        Permission::create([
            'module' => 'Customer',
            'name' => 'Update',
            'slug' => 'update-customer',
        ]);

        Permission::create([
            'module' => 'Customer',
            'name' => 'Destroy',
            'slug' => 'destroy-customer',
        ]);

        Permission::create([
            'module' => 'User',
            'name' => 'Store',
            'slug' => 'store-user',
        ]);

        Permission::create([
            'module' => 'User',
            'name' => 'Show',
            'slug' => 'show-user',
        ]);

        Permission::create([
            'module' => 'User',
            'name' => 'Update',
            'slug' => 'update-user',
        ]);

        Permission::create([
            'module' => 'User',
            'name' => 'Destroy',
            'slug' => 'destroy-user',
        ]);

        Permission::create([
            'module' => 'Role',
            'name' => 'Store',
            'slug' => 'store-role',
        ]);

        Permission::create([
            'module' => 'Role',
            'name' => 'Show',
            'slug' => 'show-role',
        ]);

        Permission::create([
            'module' => 'Role',
            'name' => 'Update',
            'slug' => 'update-role',
        ]);

        Permission::create([
            'module' => 'Role',
            'name' => 'Destroy',
            'slug' => 'destroy-role',
        ]);

        Permission::create([
            'module' => 'Settings',
            'name' => 'App',
            'slug' => 'app-settings',
        ]);

        Permission::create([
            'module' => 'Supplier',
            'name' => 'Store',
            'slug' => 'store-supplier',
        ]);

        Permission::create([
            'module' => 'Supplier',
            'name' => 'Show',
            'slug' => 'show-supplier',
        ]);

        Permission::create([
            'module' => 'Supplier',
            'name' => 'Update',
            'slug' => 'update-supplier',
        ]);

        Permission::create([
            'module' => 'Supplier',
            'name' => 'Destroy',
            'slug' => 'destroy-supplier',
        ]);

        $adminPermissions = Permission::all();
        $userPermissions = Permission::where('slug', 'like', '%customer')->get();
        $staffPermissions = Permission::where('slug', 'like', '%customer')
            ->orWhere('slug', 'like', '%user')
            ->orWhere('slug', 'like', '%role')
            ->orWhere('slug', 'like', '%settings')
            ->orWhere('slug', 'like', '%supplier')
            ->get();

        $this->adminRole->permissions()->attach($adminPermissions);
        $this->userRole->permissions()->attach($userPermissions);
        $this->staffRole->permissions()->attach($staffPermissions);

        $GoMedia = User::where('email', '=', 'hello@gomedia.co')->first();

        $GoMedia->permissions()->attach($adminPermissions);
    }

    private function dev()
    {
        $adminPermissions = Permission::all();
        $userPermissions = Permission::where('slug', 'like', '%customer')->get();
        $staffPermissions = Permission::where('slug', 'like', '%customer')
            ->orWhere('slug', 'like', '%user')
            ->orWhere('slug', 'like', '%role')
            ->orWhere('slug', 'like', '%settings')
            ->orWhere('slug', 'like', '%supplier')
            ->get();

        $user = User::where('email', '=', 'user@gomedia.co')->first();
        $staff = User::where('email', '=', 'staff@gomedia.co')->first();

        $user->permissions()->attach($userPermissions);
        $staff->permissions()->attach($staffPermissions);
    }
}
