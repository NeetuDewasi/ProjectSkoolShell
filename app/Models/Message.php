<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'user_id',
        'title',
        'email',
        'sms',
        'content',
        'message_for',
        'receiver_ids',
        'status',
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 'activated');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

}
