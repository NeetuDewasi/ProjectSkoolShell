<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_group_id',
        'school_id',
        'title',
        'document',
        'status'
    ];
    public function school(){
        return $this->belongsTo(School::class,'school_id','id');
    }
}
