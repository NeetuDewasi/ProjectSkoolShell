<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class ClassPeriodSubject extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'school_class_id',
        'school_section_id',
        'class_period_id',
        'subject_id',
        'employee_id',
        'status',
        'day',
        'detail'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function periods()
    {
        return $this->belongsTo(ClassPeriod::class, 'class_period_id', 'id');
    }
    public function teachers()
    {
        return $this->belongsTo(Employee::class);
    }
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
    public function schoolSection()
    {
        return $this->belongsTo(SchoolSection::class);
    }
}
