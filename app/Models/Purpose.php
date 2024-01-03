<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'title',
        'description',
        'status',
    ];
    public function scopeAllowed($query)
    {
       return $query->where('status', '!=','deleted');
    }
}
