<?php

namespace App\Models\Customer;

use App\Models\User;
use App\Models\Customer\Contact;
use App\Models\Activity\Activity;
use App\Models\Customer\Location;
use App\Models\Customer\ReferralSource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use SoftDeletes, HasFactory;

    protected $with = [
      'contacts',
      'locations'
    ];

    protected $fillable = [
      'type',
      'label',
      'account_manager_id',
      'general_contact_number',
      'general_email_address',
      'referral_source_id',
      'status',
      'prospect',
      'company_name',
      'company_number',
      'parent_company_id'
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function account_manager()
    {
      return $this->hasOne(User::class, 'id', 'account_manager_id');
    }

    public function referral_source()
    {
      return $this->hasOne(ReferralSource::class, 'id', 'referral_source_id');
    }

    public function parent_company()
    {
      return $this->hasOne(Customer::class, 'id', 'parent_company_id');
    }
}
