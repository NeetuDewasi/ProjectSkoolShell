<?php

namespace App\Http\Resources\School\Examinations;

use App\Http\Resources\School\Student\StudentAdmissionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignMarksResource extends JsonResource
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
            'assign_marks_id'=>$this->id,
            'add_exam_subject_id' => $this->addexam_subject_id,
            'student_admission_id'=>$this->admission_id,
            'attendance' => $this->absent,
            'marks' => $this->obtained_marks,
            'note' => $this->note,
            'status'=>$this->status,
            'students'=>new StudentAdmissionResource($this->admission),
            'exam_subjects'=>new AddExamSubjectResource($this->addexamsubjects),
        ];
    }
}
