<?php

namespace App\Http\Resources\School\Student;

use App\Http\Resources\School\Academics\SchoolClassResource;
use App\Http\Resources\School\Academics\SchoolSectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentAdmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'student_admission_id' => $this->id,
            'admission_number' => $this->admission_number,
            'roll_number' => $this->roll_number,
            'admission_date' => $this->admission_date,
            'school_class' => new SchoolClassResource($this->schoolClass),
            'school_section' => new SchoolSectionResource($this->schoolSection),
            'student_guardian' => new StudentGuardianResource($this->studentGuardian),
            'student_category' => new StudentCategoryResource($this->studentCategory),
            'student_house' => new StudentHouseListResource($this->studentHouse),
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'religion' => $this->religion,
            'cast' => $this->cast,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'student_photo' => $this->student_photo,
            'blood_group' => $this->blood_group,
            'height' => $this->height,
            'weight' => $this->weight,
            'student_sibling' => StudentSiblingResource::collection($this->siblings),
            'student_status' => $this->status,
        ];
    }
}
