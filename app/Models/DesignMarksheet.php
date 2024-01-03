<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignMarksheet extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'exam_id',
        'template',
        'heading',
        'title',
        'school_name',
        'exam_center',
        'body_text',
        'footer_text',
        'printing_date',
        'student_name',
        'father_name',
        'mother_name',
        'exam_session',
        'date_of_birth',
        'admission_number',
        'division',
        'roll_no',
        'photo',
        'class',
        'section',
        'remark',
        'background_image',
        'left_logo',
        'right_logo',
        'left_sign',
        'middle_sign',
        'right_sign',
        'status'
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }
}
