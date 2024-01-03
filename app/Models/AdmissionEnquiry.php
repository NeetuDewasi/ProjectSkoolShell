<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionEnquiry extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'user_id',
        'name',
        'phone',
        'email',
        'address_line1',
        'address_line2',
        'area',
        'location',
        'landmark',
        'city',
        'state',
        'country',
        'pincode',
        'note',
        'no_of_child',
        'status',
    ];

    public function students()
    {
        return $this->hasMany(Enquirystudent::class, 'admission_enquiry_id', 'id');
    }

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
