<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    protected $fillable = [
        'school_id',
        'class_id',
        'section_id',
        'exam_name',
        'duration',
        'exam_date',
        'exam_time',
        'subjects'
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
   public function schoolClass()
   {
       return $this->belongsTo(SchoolClass::class, 'class_id', 'id');
   }
    public function schoolSection()
    {
        return $this->belongsTo(SchoolSection::class,'section_id','id');
    }
}
