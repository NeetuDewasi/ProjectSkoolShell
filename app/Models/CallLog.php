<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'name',
        'phone',
        'date',
        'next_date',
        'call_duration_minute',
        'call_duration_seconds',
        'call_type',
        'description',
        'note',
        'status',
    ];

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
