<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeDiscount extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'name',
        'discount_code',
        'amount',
        'description',
        'status',
    ];

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
