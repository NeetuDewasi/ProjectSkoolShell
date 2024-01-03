<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignStudent extends Model
{
    protected $fillable = [
        'school_id',
        'examgroup_id',
        'exam_id',
        'class_id',
        'section_id',
        'admission_id',
        'status'
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }
}
