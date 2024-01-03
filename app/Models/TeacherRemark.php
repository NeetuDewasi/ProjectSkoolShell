<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherRemark extends Model
{
    protected $fillable = [
        'school_id',
        'examgroup_id',
        'exam_id',
        'admission_id',
        'remarks',
        'status',
        'details'
    ];
}
