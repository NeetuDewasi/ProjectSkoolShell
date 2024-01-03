<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSectionSubject extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_class_id',
        'school_section_id',
        'subject_id',
    ];

    public function scopeActive($query)
    {
        $query->where('status', '!=', 'deleted');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
