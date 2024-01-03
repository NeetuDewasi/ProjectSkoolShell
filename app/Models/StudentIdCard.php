<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentIdCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'school_name',
        'id_card_title',
        'header_color',
        'address',
        'admission_number',
        'student_name',
        'class',
        'father_name',
        'mother_name',
        'student_address',
        'phone_number',
        'date_of_birth',
        'blood_group',
        'student_photo',
        'background_image',
        'signature',
        'logo',
        'status'
    ];
    public function scopeAllowed($query){
        return $query->where('status', '!=', 'deleted') ;
    }
}
