<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'component_name',
        'path',
        'status'
    ];

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
