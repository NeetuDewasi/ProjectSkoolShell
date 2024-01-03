<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
   protected $fillable = [
        'school_id',
        'name',
        'description',
        'status',
        'details',
   ];
   public function scopeActive($query)
   {
    return $query->where('status','activated');

   }

}
