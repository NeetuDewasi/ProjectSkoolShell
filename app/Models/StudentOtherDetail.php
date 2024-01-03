<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentOtherDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'admission_id',
        'national_identification_number',
        'local_identification_number',
        'rte',
        'previous_school',
        'note',
        'status'
    ];
}
