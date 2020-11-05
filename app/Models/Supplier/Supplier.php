<?php

namespace App\Models\Supplier;

use App\Models\User;
use App\Models\Supplier\Contact;
use App\Models\Activity\Activity;
use App\Models\Supplier\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use SoftDeletes, HasFactory;

    protected $with = [
      'contacts',
      'locations'
    ];

    protected $fillable = [
      'company_name',
      'label',
      'account_manager_id',
      'general_contact_number',
      'general_email_address',
      'status',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }


    public function account_manager()
    {
      return $this->hasOne(User::class, 'id', 'account_manager_id');
    }

}
