<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'name',
        'status',
    ];
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
    public function department()
    {
        return $this->belongsToMany(Department::class,'inventory_item_department','inventory_add_department_id','inventory_item_department_id');
    }

    public function employee()
    {
        return $this->belongsToMany(Employee::class,'inventory_item_employee_department','inventory_item_employee_id','inventory_item_department_id');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }
}
