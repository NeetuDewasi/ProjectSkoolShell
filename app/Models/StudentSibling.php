<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSibling extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'sibling_id',
        'relation',
    ];

    public function student()
    {
        return $this->belongsTo(Admission::class, 'student_id', 'id');
    }
}
