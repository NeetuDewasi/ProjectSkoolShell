<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquirystudent extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'admission_enquiry_id',
        'school_class_id',
        'name',
        'status',
    ];

    public function schoolClass(){
        return $this->belongsTo(SchoolClass::class , 'school_class_id' , 'id');
    }
    public function admissionEnquiry()
    {
        return $this->belongsTo(AdmissionEnquiry::class, 'admission_enquiry_id', 'id');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
