<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHostel extends Model
{
    protected $fillable = [
        'school_id',
        'admission_id',
        'hostel_id',
        'room_type_id',
        'is_hostal',
        'bed_number',
        'status'
    ];
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }
}
