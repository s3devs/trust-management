<?php

use Database\Seeders\PermissionSeeder;
use Database\Seeders\ReferralSourcesTableSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Migrations\Migration;

class RunProductionSeeders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeders = [
            new RoleSeeder(),
            new UserSeeder(),
            new PermissionSeeder(),
            new ReferralSourcesTableSeeder()
        ];

        foreach($seeders as $seeder) {
            $seeder->run(true);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
