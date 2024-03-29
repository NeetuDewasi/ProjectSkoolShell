<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'admission_id',
        'title',
        'document',
        'status'
    ];
}
