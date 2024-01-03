<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'certificate_name',
        'header_right_text',
        'header_left_text',
        'body_text',
        'footer_right_text',
        'footer_left_text',
        'footer_center_text',
        'header_height',
        'footer_height',
        'body_width',
        'body_height',
        'student_photo',
        'background_image',
        'status'

    ];
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
