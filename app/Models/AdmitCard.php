<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmitCard extends Model
{
    protected $fillable = [
        'school_id',
        'exam_id',
        'template',
        'heading',
        'title',
        'school_name',
        'exam_center',
        'footer_text',
        'student_name',
        'father_name',
        'mother_name',
        'date_of_birth',
        'admission_number',
        'roll_no',
        'student_address',
        'gender',
        'phone_number',
        'class',
        'section',
        'background_image',
        'signature',
        'left_logo',
        'right_logo',
        'status'
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }
}
