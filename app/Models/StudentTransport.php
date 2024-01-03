<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;

class StudentTransport extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'admission_id',
        'is_transport',
        'school_route_id',
        'status',

    ];
    public function schoolRoute(){
        return $this->belongsTo(SchoolRoute::class);
    }
}
