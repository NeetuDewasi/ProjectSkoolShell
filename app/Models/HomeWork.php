<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'class_id',
        'section_id',
        'subject_id',
        'title',
        'homework_for',
        'issuing_date',
        'submission_date',
        'document',
        'description',
        'evaluation_date',
        'status',
    ];

    public function schoolClass(){
        return $this->belongsTo(SchoolClass::class , 'class_id' , 'id');
    }

    public function schoolSection(){
        return $this->belongsTo(SchoolSection::class, 'section_id', 'id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
