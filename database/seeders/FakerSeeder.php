<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\Location as SLocation;
use App\Models\Supplier\Contact as SContact;
use App\Models\Customer\Customer;
use App\Models\Customer\Contact as CContact;
use App\Models\Customer\Location as CLocation;

class FakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::factory()->count(100)->create();
      Customer::factory()->count(100)->create()->each(function ($customer) {
        $customer->locations()->saveMany(CLocation::factory()->count(rand(1,5))->make());
        $customer->contacts()->saveMany(CContact::factory()->count(rand(1,5))->make([
          'location_id' => $customer->locations()->first()
        ]));
      });
      Supplier::factory()->count(100)->create()->each(function ($supplier) {
        $supplier->locations()->saveMany(SLocation::factory()->count(rand(1,5))->make());
        $supplier->contacts()->saveMany(SContact::factory()->count(rand(1,5))->make([
          'location_id' => $supplier->locations()->first()
        ]));
      });
    }
}
