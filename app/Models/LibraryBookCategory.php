<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryBookCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'status'
    ];

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
