<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'supplier_contacts';

    protected $fillable = [
      'supplier_id',
      'label',
      'first_name',
      'surname',
      'role',
      'email_address',
      'contact_number',
      'default',
      'accounts',
      'location_id',
    ];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
