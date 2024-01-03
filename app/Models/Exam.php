<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'school_class_id',
        'school_section_id',
        'subject_id',
        'exam_time',
        'exam_date',
        'status',
    ];
    public function subjects(){
        return $this->hasMany(Subject::class);
    }
}
