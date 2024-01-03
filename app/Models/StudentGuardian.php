<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGuardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'admission_id',
        'if_guardian_is',
        'father_first_name',
        'father_middle_name',
        'father_last_name',
        'father_mobile',
        'father_alternative_mobile',
        'father_occupation',
        'father_email',
        'father_alternate_email',
        'father_photo',
        'mother_first_name',
        'mother_middle_name',
        'mother_last_name',
        'mother_mobile',
        'mother_alternative_mobile',
        'mother_occupation',
        'mother_email',
        'mother_alternate_email',
        'mother_photo',
        'father_alternative_mobile',
        'guardian_first_name',
        'guardian_middle_name',
        'guardian_last_name',
        'guardian_mobile',
        'guardian_alternative_mobile',
        'guardian_occupation',
        'guardian_email',
        'guardian_alternate_email',
        'guardian_photo',
        'guardian_relation',
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
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
