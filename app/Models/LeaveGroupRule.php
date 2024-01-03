<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveGroupRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'department_id',
        'leave_group_id',
        'leave_type_id',
        'rule_title',
        'leave',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function leaveGroup()
    {
        return $this->belongsTo(LeaveGroup::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
