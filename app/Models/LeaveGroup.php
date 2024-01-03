<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'department_id',
        'title',
        'status',
    ];

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
