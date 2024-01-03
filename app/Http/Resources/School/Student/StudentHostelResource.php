<?php

namespace App\Http\Resources\School\Student;

use App\Http\Resources\School\Hostel\HostelListResource;
use App\Http\Resources\School\Hostel\HostelResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentHostelResource extends JsonResource
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
            'admission_hostel_id' => $this->id,
            'student_school_id' => $this->school_id,
            'student_is_hostel' => $this->is_hostal,
            'student_admission_id' => $this->admission_id,
            'student_hostel_id' => $this->hostel_id,
            'student_room_type_id' => $this->room_type_id,
            'student_bed_number' => $this->bed_number,

            'student_hostel_name' =>$this->hostel->hostel_name,
            'student_status' => $this->status,
        ];
    }
}
