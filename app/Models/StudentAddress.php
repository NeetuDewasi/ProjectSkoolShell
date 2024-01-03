<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'admission_id',
        'isCurrent',
        'isPermanent',
        'permanent_address_line1',
        'permanent_address_line2',
        'permanent_location',
        'permanent_landmark',
        'permanent_city',
        'permanent_pincode',
        'permanent_state',
        'permanent_country',
        'current_address_line1',
        'current_address_line2',
        'current_location',
        'current_landmark',
        'current_city',
        'current_pincode',
        'current_state',
        'current_country',
        'status'
    ];
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
