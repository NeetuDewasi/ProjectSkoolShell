<?php

namespace App\Http\Resources\School\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentGuardianResource extends JsonResource
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
            'student_guardian_id' => $this->id,
            'student_school_id' => $this->school_id,
            'student_admission_id' => $this->admission_id,
            'if_guardian' => $this->if_guardian_is,
            'father' => [
                'first_name' => $this->father_first_name,
                'middle_name' => $this->father_middle_name,
                'last_name' => $this->father_last_name,
                'mobile' => $this->father_mobile,
                'alternative_mobile' => $this->father_alternative_mobile,
                'occupation' => $this->father_occupation,
                'email' => $this->father_email,
                'alternate_email' => $this->father_alternate_email,
                'photo' => $this->father_photo,
            ],
            'mother' => [
                'first_name' => $this->mother_first_name,
                'middle_name' => $this->mother_middle_name,
                'last_name' => $this->mother_last_name,
                'mobile' => $this->mother_mobile,
                'alternative_mobile' => $this->mother_alternative_mobile,
                'occupation' => $this->mother_occupation,
                'email' => $this->mother_email,
                'alternate_email' => $this->mother_alternate_email,
                'photo' => $this->mother_photo,
            ],
            'other' => [
                'first_name' => $this->guardian_first_name,
                'middle_name' => $this->guardian_middle_name,
                'last_name' => $this->guardian_last_name,
                'mobile' => $this->guardian_mobile,
                'alternative_mobile' => $this->guardian_alternative_mobile,
                'occupation' => $this->guardian_occupation,
                'email' => $this->guardian_email,
                'alternate_email' => $this->guardian_alternate_email,
                'relation' => $this->guardian_relation,
                'photo' => $this->guardian_photo,

            ],

            'address_id' => $this->address_id,
            'school_id' => $this->school_id,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'location' => $this->location,
            'landmark' => $this->landmark,
            'city' => $this->city,
            'pincode' => $this->pincode,
            'state' => $this->state,
            'country' => $this->country,
            'status' => $this->status
        ];
    }
}
