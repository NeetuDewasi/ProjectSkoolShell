<?php

namespace App\Http\Resources\School\Fees_Collection;

use App\Http\Resources\School\Academics\SchoolClassResource;
use App\Http\Resources\School\Academics\SchoolSectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FeeAdmissionResource extends JsonResource
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
            'student_admission_number' => $this->admission_number,
            'student_admission_date' => $this->admission_date,
            'school_class' =>new SchoolClassResource($this->schoolClass),
            'school_section' => new SchoolSectionResource($this->schoolSection),
            'student_first_name' => $this->first_name,
            'student_middle_name' => $this->middle_name,
            'student_last_name' => $this->last_name,
            'student_date_of_birth' => $this->date_of_birth,
            'student_gender' => $this->gender,
            'student_category' => $this->category,
            'student_religion' => $this->religion,
            'student_cast' => $this->cast,
            'student_mobile' => $this->mobile,
            'student_email' => $this->email,
            'student_student_photo' => $this->student_photo,
            'student_blood_group' => $this->blood_group,
            'student_height' => $this->height,
            'student_weight' => $this->weight,
            'student_status' => $this->status

        ];
    }
}
