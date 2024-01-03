<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'department_id',
        'registration_id',
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'email',
        'gender',
        'dob',
        'date_of_join',
        'mobile',
        'emergency_contact_name',
        'emergency_contact_number',
        'pincode',
        'marital_status',
        'photo',
        'current_address1',
        'current_address2',
        'current_area',
        'current_location',
        'current_landmark',
        'current_city',
        'current_state',
        'current_country',
        'current_pincode',
        'permanent_address1',
        'permanent_address2',
        'permanent_area',
        'permanent_location',
        'permanent_landmark',
        'permanent_city',
        'permanent_state',
        'permanent_country',
        'permanent_pincode',
        'created_by',
        'status',
    ];
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

    public function scopeTeacher($query)
    {
        return $query->whereHas('department', function ($query) {
            $query->where('name', 'Teacher');
        });
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'employee_id', 'subject_id');
    }

    public function scopeDriver($query)
    {
        return $query->whereHas('department', function ($query) {
            $query->where('name', 'Driver');
        });
    }

    public function attendances()
    {
        return $this->hasMany(EmployeeAttendance::class);
    }
}
