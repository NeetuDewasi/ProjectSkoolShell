<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'school_class_id',
        'school_section_id',
        'student_category_id',
        'student_house_id',
        'admission_number',
        'roll_number',
        'admission_date',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'category',
        'religion',
        'cast',
        'mobile',
        'email',
        'student_photo',
        'blood_group',
        'height',
        'weight',
        'status'
    ];
    public function schoolSection()
    {
        return $this->belongsTo(SchoolSection::class);
    }
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'activated')->orderBy('first_name', 'asc');
    }

    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function studentGuardian()
    {
        return $this->hasOne(StudentGuardian::class);
    }
    public function studentCategory()
    {
        return $this->belongsTo(StudentCategory::class);
    }

    public function scopeExStudent($query)
    {
        return $query->where('status', 'ex-student');
    }

    public function siblings()
    {
        return $this->hasMany(StudentSibling::class, 'sibling_id', 'id');
    }
    public function studentAddress(){
        return $this->hasOne(StudentAddress::class);
    }
    public function studentTransport(){
        return $this->hasOne(StudentTransport::class);
    }
    public function studentHouse(){
        return $this->belongsTo(StudentHouse::class);
    }
    public function studentHostel(){
        return $this->hasOne(StudentHostel::class);
    }
    public function Hostel()
    {
        return $this->hasOne(Hostel::class,'Hostel_id', 'id');
    }
    public function studentDocument(){
        return $this->hasMany(StudentDocument::class);
    }
    public function otherDetails(){
        return $this->hasOne(StudentOtherDetail::class);
    }
    public function studentIdCard(){
        return $this->hasOne(StudentIdCard::class);
    }
    public function assignExamMarks()
    {
        return $this->hasMany(AssignExamMark::class);
    }
}
