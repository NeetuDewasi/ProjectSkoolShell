<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignRoute extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id', 'vehicle_id', 'school_route_id', 'employee_id', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class,'vehicle_id','id');

    }

    public function route()
    {
        return $this->belongsTo(SchoolRoute::class, 'school_route_id', 'id');
    }

    public function driver()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
