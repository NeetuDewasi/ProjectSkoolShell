<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'number',
        'status'
    ];


    public function schoolSections()
    {
        return $this->belongsToMany(SchoolSection::class, 'school_class_school_section', 'school_class_id', 'school_section_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'activated')->orderBy('number', 'asc');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
