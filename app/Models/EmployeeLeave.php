<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'employee_id',
        'leave_type_id',
        'leave_from',
        'leave_to',
        'leave_reason',
        'documents',
        'response_by',
        'response_at',
        'response_message',
        'status',
    ];

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
