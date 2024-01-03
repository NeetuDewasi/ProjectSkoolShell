<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignExamMark extends Model
{
    protected $fillable = [
        'school_id',
        'examgroup_id',
        'exam_id',
        'addexam_subject_id',
        'admission_id',
        'session_id',
        'school_class_id',
        'school_section_id',
        'absent',
        'obtained_marks',
        'note',
        'status',
        'details'
    ];

    public function admission(){
        return $this->belongsTo(Admission::class);
    }
    public function addexamsubjects(){
        return $this->belongsTo(AddExamSubject::class, 'addexam_subject_id', 'id');
    }
    public function scopeActive($query)
    {
        return $query->where('status','activated');
    }
}

