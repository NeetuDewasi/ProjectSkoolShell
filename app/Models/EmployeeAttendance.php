<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'employee_id',
        'date',
        'attendance',
        'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
