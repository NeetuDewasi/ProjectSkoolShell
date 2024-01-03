<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'name',
        'description',
        'status',
    ];
    public function scopeAllowed($query)
    {
       return $query->where('status', '!=','deleted');
    }
}
