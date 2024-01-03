<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'user_id',
        'school_class_id',
        'school_section_id',
        'content_type',
        'title',
        'content_for',
        'is_publish',
        'published_at',
        'description',
        'documents',
        'status'
    ];

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
    public function schoolSection()
    {
        return $this->belongsTo(SchoolSection::class);
    }
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
