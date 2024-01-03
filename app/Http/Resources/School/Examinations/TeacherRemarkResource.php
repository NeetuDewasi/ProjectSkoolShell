<?php

namespace App\Http\Resources\School\Examinations;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherRemarkResource extends JsonResource
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
            'teacher_remarks_id' => $this->id,
            'student_admission_id' => $this->admission_id,
            'teacher_remarks' => $this->remarks,
            'status' => $this->status
        ];
    }
}
