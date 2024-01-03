<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignModule extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_group_id',
        'school_id',
        'name',
        'status'
    ];
    public function schoolGroup(){
        return $this->belongsTo(SchoolGroup::class);
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
    public function scopeAllowed($query){
        return $query->where('status','!=','deleted');
    }
    // public function categories()
    // {
    //     return $this->belongsTo(Category::class);
    // }
}
