<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'hostel_name',
        'contact_person',
        'contact_number',
        'alternative_contact_number',
        'email',
        'intake',
        'address_line1',
        'address_line2',
        'type',
        'area',
        'landmark',
        'city',
        'state',
        'country',
        'pincode',
        'description',
        'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=','deleted');
    }

}
