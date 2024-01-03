<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class libraryAddLibraryCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'student_id',
        'library_card_no',
        'status',
        'detail'
    ];
}
