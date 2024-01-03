<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'employee_id',
        'account_number',
        'bank_name',
        'ifsc_code',
        'branch_name',
        'status',
    ];
}
