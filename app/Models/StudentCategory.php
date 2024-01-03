<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCategory extends Model
{
    protected $fillable = [
        'school_id',
        'name',
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
}
