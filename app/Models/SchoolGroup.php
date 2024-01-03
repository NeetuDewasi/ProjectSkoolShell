<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person_name',
        'mobile',
        'alternative_mobile',
        'email',
        'alternative_email',
        'is_permanent_address',
        'activation_key',
        'activation_start_date',
        'activation_end_date',
        'status'
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 'activated')->orderBy('name', 'asc');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status','!=','deleted');
    }
    // public function schools(){
    //     return $this->hasMany(School::class,'school_group_id', 'id');
    // }
}
