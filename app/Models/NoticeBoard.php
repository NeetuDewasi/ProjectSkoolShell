<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'description',
        'notice_on',
        'publish_on',
        'message_for',
        'status'
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 'activated')->orderBy('title', 'asc');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }
}
