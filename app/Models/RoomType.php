<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'school_id',
        'hostel_id',
        'room_type',
        'description',
        'status',
    ];

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
    public function hostels()
    {
        return $this->belongsTo(Hostel::class,'hostel_id','id');
    }
}
