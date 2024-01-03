<?php

namespace App\Http\Resources\School\Examinations;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\School\Student\StudentAdmissionResource;

class EnterMarksResource extends JsonResource
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
            'entermarks_id' => $this->id,
            'enter_examgroup_id' => $this->examgroup_id,
            'enter_exam_id' => $this->exam_id,
            'addexam_subject_id' => $this->addexam_subject_id,
            'student_admission_id' => $this->admission_id,
            'is_absent' => $this->absent,
            'subject_marks' => $this->obtained_marks,
            'enter_note' => $this->note,
            'students' => new StudentAdmissionResource($this->admission),
            'subjects' => new AddExamSubjectResource($this->subjects),
            'status' => $this->status
        ];
    }
    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
    public function subjects()
    {
        return $this->belongsTo(AddExamSubject::class);
    }
}
