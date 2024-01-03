<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Assign;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'vehicle_no',
        'registration_no',
        'vehicle_model',
        'model_year',
        'insurance_date',                                                                              
        'puc_date',
        'service_date',
        'note',
        'status',
        'detail',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

    public function latestRoute()
    {
        return $this->hasOne(AssignRoute::class)->latest();
    }
}
