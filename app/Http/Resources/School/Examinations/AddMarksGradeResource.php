<?php

namespace App\Http\Resources\School\Examinations;

use App\Models\ExamType;
use Illuminate\Http\Resources\Json\JsonResource;

class AddMarksGradeResource extends JsonResource
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
            'grade_id'=>$this->id,
            'grade_exam_id' => $this->grade_exam_id,
            'exam_type_id' => $this->exam_type_id,
            'grade_exam_type'=>new ExamTypeResource($this->examType),
            'grade' => $this->grade_name,
            'percent_upto' => $this->percentage_upto,
            'percent_from' => $this->percentage_from,
            'grade_point' => $this->grade_point,
        ];
    }
}
