<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'supplier_locations';

    protected $fillable = [
      'supplier_id',
      'label',
      'address_line_1',
      'address_line_2',
      'address_line_3',
      'address_city',
      'address_county',
      'address_postcode',
      'address_country',
      'default',
    ];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class);
    }
}
