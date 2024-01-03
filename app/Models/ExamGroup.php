<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamGroup extends Model
{
    use HasFactory;

    protected $fillable = [
            'id',
            'school_id',
            'class_id',
            'group_name',
            'exam_type',
            'description',
            'detail',
            'status',
       ];
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id', 'id');
    }
    public function examType()
    {
        return $this->belongsTo(ExamType::class, 'exam_type', 'id');
    }
    public function scopeActive($query){
        return $query->where('status','activated');
    }
    public function exams()
    {
        return $this->hasMany(AddNewExam::class, 'exam_group_id', 'id');
    }
}
