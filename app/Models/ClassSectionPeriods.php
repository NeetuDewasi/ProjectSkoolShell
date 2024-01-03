<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSectionPeriods extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id', 'school_class_id', 'school_section_id', 'class_period_id',
    ];

    public function period()
    {
        return $this->belongsTo(ClassPeriod::class, 'class_period_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
