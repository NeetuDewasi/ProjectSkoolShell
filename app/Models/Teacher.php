<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'first_name',
        'middle_name',
        'last_name',
        'mobile',
        'alternative_mobile',
        'email',
        'alternative_email',
        'address_line1',
        'address_line2',
        'location',
        'landmark',
        'city',
        'pincode',
        'state',
        'country',
        'status'
    ];
}
