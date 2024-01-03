<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'subject_code',
        'subject_type',
        'status'
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 'activated')->orderBy('name', 'asc');
    }

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_section_subjects', 'school_class_id', 'id');
    }

    public function sections()
    {
        return $this->belongsToMany(SchoolSection::class, 'class_section_subjects', 'school_section_id', 'id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Employee::class, 'subject_teacher', 'subject_id', 'employee_id');
    }
}
