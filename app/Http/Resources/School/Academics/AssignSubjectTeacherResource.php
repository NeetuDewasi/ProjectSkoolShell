<?php

namespace App\Http\Resources\School\Academics;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignSubjectTeacherResource extends JsonResource
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
            'subject_id' => $this->subject_id,
            'teacher_id' => $this->employee_id,
        ];
    }
}
