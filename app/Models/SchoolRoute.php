<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'route_name',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
