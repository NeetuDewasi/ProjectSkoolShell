<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'employee_id',
        'fb_url',
        'twitter_url',
        'instagram_url',
        'likedin_url',
        'status',
    ];
}
