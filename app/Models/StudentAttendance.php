<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'admission_id',
        'date',
        'attendance',
        'status'
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 'activated')->orderBy('admission_number', 'asc');
    }

    public function student()
    {
        return $this->belongsTo(Admission::class);
    }
}
