<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolRoutePoints extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'school_route_id',
        'vehicle_no',
        'driver_name',
        'driver_license',
        'phone',
        'pickup_point',
        'pickup_point_location',
        'position',
        'status',
    ];
}
