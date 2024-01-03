<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postal extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'from_title',
        'to_title',
        'ref_no',
        'postal_type',
        'date',
        'document',
        'note',
        'status',
        'address',
    ];
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
