<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintAdmitCard extends Model
{

     protected $fillable = [
        'school_id',
        'school_class_id',
        'school_section_id',
        'admission_id',
        'admit_card_id',
        'status',
        'detail'
    ];
}
