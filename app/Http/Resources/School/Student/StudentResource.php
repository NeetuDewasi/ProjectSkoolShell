<?php

namespace App\Http\Resources\School\Student;

use App\Http\Resources\School\Academics\SchoolClassResource;
use App\Http\Resources\School\Academics\SchoolSectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'school_class' => new SchoolClassResource($this->schoolClass), // schoolClass is function of relationship
            'school_section' => new SchoolSectionResource($this->schoolSection),
            'student_first_name' => $this->first_name,
            'student_middle_name' => $this->middle_name,
            'student_last_name' => $this->last_name,
            'student_date_of_birth' => $this->date_of_birth,
            'student_avatar' => $this->student_photo,
        ];
    }
}
