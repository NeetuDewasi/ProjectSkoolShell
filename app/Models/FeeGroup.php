<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'school_class_id',
        'name',
        'description',
        'status',
    ];

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id', 'id');
    }
}
