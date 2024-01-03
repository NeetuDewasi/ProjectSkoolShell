<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'contact_person_name',
        'mobile',
        'alternative_mobile',
        'email',
        'alternative_email',
        'status',
    ];
}
