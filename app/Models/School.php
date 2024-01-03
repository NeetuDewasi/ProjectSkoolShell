<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_group_id',
        'user_id',
        'name',
        'contact_person_name',
        'mobile',
        'alternative_mobile',
        'email',
        'alternative_email',
        'password',
        'password_text',
        'address_line1',
        'address_line2',
        'location',
        'landmark',
        'city',
        'pincode',
        'state',
        'country',
        'is_same_address',
        'current_address_line1',
        'current_address_line2',
        'current_location',
        'current_landmark',
        'current_city',
        'current_pincode',
        'current_state',
        'current_country',
        'permanent_address_line1',
        'permanent_address_line2',
        'permanent_location',
        'permanent_landmark',
        'permanent_city',
        'permanent_pincode',
        'permanent_state',
        'permanent_country',
        'activation_key',
        'activation_start_date',
        'activation_end_date',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function schoolGroup()
    {
        return $this->belongsTo(SchoolGroup::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'activated')->orderBy('name', 'asc');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status','!=','deleted');
    }
    public function schoolDocuments(){
        return $this->hasMany(SchoolDocument::class);
    }
}
