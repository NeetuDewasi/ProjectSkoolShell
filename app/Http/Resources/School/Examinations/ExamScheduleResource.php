<?php

namespace App\Http\Resources\School\Examinations;

use App\Http\Resources\School\Academics\SchoolClassResource;
use App\Http\Resources\School\Academics\SchoolSectionResource;
use App\Http\Resources\School\Academics\SubjectResource;
use App\Models\ExamSchedule;
use App\Models\Subject;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $subject_list = null;
        if ($this->subjects) {
                $subject_list = Subject::whereIn('id', json_decode($this->subjects))->get();
                if(count($subject_list)>0){
                    $subject_list = SubjectResource::collection($subject_list);
                }
        }
        return [
            'examSchedule_id' => $this->id,
            'school_class' => new SchoolClassResource($this->schoolClass),
            'school_section' => new SchoolSectionResource($this->schoolSection),
            'schedule_exam_name' =>$this->exam_name,
            'schedule_exam_date' =>$this->exam_date,
            'schedule_time' =>$this->exam_time,
            'exam_duration'=>$this->duration,
            'exam_subjects' => $subject_list,
        ];
    }
}
