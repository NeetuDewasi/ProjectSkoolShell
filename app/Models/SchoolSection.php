<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'status'
    ];
    public function schoolSections()
    {
        return $this->belongsToMany(SchoolSection::class, 'school_class_school_section', 'school_class_id', 'school_section_id');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'activated')->orderBy('name', 'asc');
    }

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'school_class_school_section', 'school_class_id', 'school_section_id');
    }
}
