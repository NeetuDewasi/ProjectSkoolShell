<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class
FeeMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'class_id',
        'fee_group_id',
        'fee_types_id',
        'due_date',
        'amount',
        'fine_type',
        'fine_amount',
        'details',
        'status',
    ];
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id', 'id');
    }
    public function feeGroup()
    {
        return $this->belongsTo(FeeGroup::class, 'fee_group_id', 'id');
    }
    public function feesType()
    {
        return $this->belongsTo(FeeType::class, 'fee_types_id', 'id');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
