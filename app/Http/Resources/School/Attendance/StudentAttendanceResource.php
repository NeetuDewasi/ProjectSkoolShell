<?php

namespace App\Http\Resources\School\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentAttendanceResource extends JsonResource
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
            'student_id' => $this->id,
            'school_class' => $this->schoolClass,
            'school_section' => $this->schoolSection,
            'student_admission_number' => $this->admission_number,
            'student_role_number' => $this->role_number,
            'student_first_name' => $this->first_name,
            'student_last_name' => $this->last_name,
            'attendance' => $this->attendances && count($this->attendances) > 0 ? $this->attendances[0]->attendance : 1,
            'status' => $this->status
        ];
    }
}
