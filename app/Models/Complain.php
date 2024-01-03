<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'complain_type_id',
        'source_id',
        'complain_by',
        'phone',
        'date',
        'action_by',
        'assigned',
        'document',
        'description',
        'status',
    ];
    public function complainType(){
        return $this->belongsTo(ComplainType::class, 'complain_type_id', 'id');
    }

    public function source(){
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}

