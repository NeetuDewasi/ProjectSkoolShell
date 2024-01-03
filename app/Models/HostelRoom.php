<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Function_;

class HostelRoom extends Model
{
    protected $fillable = [
        'school_id',
        'hostel_id',
        'room_type_id',
        'room_name',
        'number_of_bed',
        'cost_per_bed',
        'description'
    ];
    public function hostel(){
        return $this->belongsTo(Hostel::class, 'hostel_id', 'id');
    }
    public function roomType(){
        return $this->belongsTo(RoomType::class, 'room_type_id', 'id');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
