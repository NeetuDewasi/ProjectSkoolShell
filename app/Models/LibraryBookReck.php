<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryBookReck extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'reck_name', 'shelf_count', 'status'];

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
