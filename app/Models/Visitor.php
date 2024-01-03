<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'purpose_id',
        'name',
        'phone',
        'date',
        'email',
        'id_card',
        'no_of_person',
        'in_time',
        'out_time',
        'document',
        'note',
        'status',
    ];
    public function purpose()
    {
        return $this->belongsTo(Purpose::class, 'purpose_id', 'id');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
