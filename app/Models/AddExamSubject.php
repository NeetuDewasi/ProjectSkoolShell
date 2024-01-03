<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddExamSubject extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'subject_id',
        'examgroup_id',
        'exam_id',
        'subject_id',
        'exam_date',
        'exam_time',
        'duration',
        'room_no',
        'max_marks',
        'min_marks',
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
    public function subjects()
    {
        return $this->belongsTo(Subject::class,'subject_id','id');
    }
}
