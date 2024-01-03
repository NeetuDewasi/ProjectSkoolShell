<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarksGrade extends Model
{
    protected $fillable = [
        'id',
        'school_id',
        'exam_type_id',
        'grade_name',
        'percentage_upto',
        'percentage_from',
        'grade_point',
        'status',
    ];
    public function examType(){
        return $this->belongsTo(ExamType::class, 'exam_type_id','id');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }
}
