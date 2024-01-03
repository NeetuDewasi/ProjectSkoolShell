<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateCertificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'school_class_id',
        'school_section_id',
        'admission_id',
        'certificate_id',
        'status',
        'detail'
    ];
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
