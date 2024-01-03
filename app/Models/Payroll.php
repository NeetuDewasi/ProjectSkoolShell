<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'employee_id',
        'epf_no',
        'basic_salary',
        'contract_type',
        'working_shift',
        'location',
        'status',
    ];
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
