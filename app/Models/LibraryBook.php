<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'category_id',
        'reck_id',
        'shelf_number',
        'code',
        'title',
        'author',
        'cost',
        'fine',
        'inventory_date',
        'cover',
        'isbn_number',
        'quantity',
        'publisher',
        'status'
    ];

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
