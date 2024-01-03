<?php

namespace App\Http\Resources\School\Examinations;

use Illuminate\Http\Resources\Json\JsonResource;
class AddExamSubjectResource extends JsonResource
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
            'exam_subject_id'=>$this->id,
            'exam_group_id'=>$this->examgroup_id,
            'exam_id' => $this->exam_id,
            'exam_date' => $this->exam_date,
            'exam_time' => $this->exam_time,
            'exam_duration'=>$this->duration,
            'exam_room_no'=>$this->room_no,
            'exam_maxmarks'=>$this->max_marks,
            'exam_minmarks'=>$this->min_marks,
            'exam_subject'=>$this->subject_id,
            'subjects'=>new SubjectDropdownResource($this->subjects),
            'exam_status'=>$this->status,

        ];
    }
}
