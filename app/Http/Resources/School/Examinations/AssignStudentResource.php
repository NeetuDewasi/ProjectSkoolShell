<?php

namespace App\Http\Resources\School\Examinations;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignStudentResource extends JsonResource
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
            'examGroup_id' => $this->examgroup_id,
            'newExam_id' => $this->exam_id,
            'classId'=> $this->class_id,
            'selectedSection'=> $this->section_id,
            'selecteIds'=> $this->admission_id
        ];
    }
}
