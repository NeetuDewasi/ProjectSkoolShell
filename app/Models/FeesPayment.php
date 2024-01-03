<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'fees_master_id',
        'fee_id',
        'admission_id',
        'receipt_number',
        'invoice_number',
        'amount_paid',
        'discount_amount',
        'fine_amount',
        'payment_mode',
        'status',
    ];
}
