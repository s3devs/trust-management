<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'customer_contacts';

    protected $fillable = [
      'customer_id',
      'label',
      'first_name',
      'surname',
      'email_address',
      'contact_number',
      'default',
      'accounts',
      'location_id',
      'role'
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
