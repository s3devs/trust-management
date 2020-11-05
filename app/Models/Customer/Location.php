<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'customer_locations';

    protected $fillable = [
      'customer_id',
      'label',
      'address_line_1',
      'address_line_2',
      'address_line_3',
      'address_city',
      'address_county',
      'address_postcode',
      'address_country',
      'default',
      'accounts'
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }
}
