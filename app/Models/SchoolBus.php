<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolBus extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'bus_no',
        'vehicle_name',
        'vehicle_no',
        'insurance_date',
        'puc_date',
        'service_date',
        'status'
    ];
}
