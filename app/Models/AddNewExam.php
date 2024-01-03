<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddNewExam extends Model
{
    protected $fillable = [
                'school_id',
                'session_id',
                'exam_group_id',
                'exam_name',
                'publish',
                'publish_result',
                'roll_no',
                'description',
                'status'
    ];
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id', 'id');
    }
    public function schoolSection()
    {
        return $this->belongsTo(SchoolSection::class, 'section_id', 'id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    public function schoolSession()
    {
        return $this->belongsTo(SchoolSession::class, 'session_id', 'id');
    }
    public function examGroup()
    {
        return $this->belongsTo(ExamGroup::class, 'exam_group_id', 'id');
    }
}
