<?php

namespace App\Http\Resources\School\Examinations;

use App\Models\Subject;
use App\Http\Resources\School\Academics\SubjectResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AddNewExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $subject_list = null;
        // if ($this->subjects) {
        //     $subject_list = Subject::whereIn('id', json_decode($this->subjects))->get();
        //     if (count($subject_list) > 0) {
        //         $subject_list = SubjectResource::collection($subject_list);
        //     }
        // }
        return [
            'newExam_id' => $this->id,
            'newExam_schoolId' => $this->school_id,
            'session_id' => $this->session_id,
            'schoolSession'=>$this->schoolSession != null ? $this->schoolSession->session : null,
            'exam_groups' => $this->examGroup != null ? $this->examGroup->group_name : null,
            // 'exam_type' => $this->examGroup != null ? $this->examGroup->exam_type : null,
            // 'group_description' => $this->examGroup != null ? $this->examGroup->description : null,
            'newExam_name' => $this->exam_name,
            'newExam_publish' => $this->publish,
            'newExam_publish_result' => $this->publish_result,
            'newExam_rollNo' => $this->roll_no,
            'newExam_description' => $this->description,
            // 'exam_subjects' => $subject_list,
            'status'=>$this->status,
        ];
    }
}
