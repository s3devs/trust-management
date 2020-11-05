<?php

namespace Database\Seeders;

use App\Models\Customer\ReferralSource;
use Illuminate\Database\Seeder;

class ReferralSourcesTableSeeder extends Seeder
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

  private function prod()
  {
    $referral_sources = ['Google', 'Word of Mouth', 'Facebook', 'Twitter', 'LinkedIn', 'Email Marketing'];
    foreach ($referral_sources as $i => $item) {
      ReferralSource::create([
        'name'              => $item,
        'created_by'        => 1,
        'updated_by'        => 1,
      ]);
    }
  }

  private function dev()
  {
    // No additional development
  }
}
