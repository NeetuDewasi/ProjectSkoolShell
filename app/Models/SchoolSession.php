<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'session',
        'status'
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }

}
