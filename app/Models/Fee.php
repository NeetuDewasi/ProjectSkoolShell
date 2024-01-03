<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'admission_id',
        'fees_master_id',
        'fee_discount_id',
        'date',
        'amount',
        'discount_amount',
        'fine_amount',
        'payment_mode',
        'description',
        'status',
        'fee_status',
    ];
    public function studentAdmission()
    {
        return $this->belongsTo(Admission::class, 'admission_id', 'id');
    }
    public function feesMaster()
    {
        return $this->belongsTo(FeeMaster::class, 'fees_master_id', 'id');
    }
    public function feeDiscount()
    {
        return $this->belongsTo(FeeDiscount::class, 'fee_discount_id', 'id');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
