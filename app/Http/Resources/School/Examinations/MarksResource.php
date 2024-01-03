<?php

namespace App\Http\Resources\School\Examinations;

use Illuminate\Http\Resources\Json\JsonResource;

class MarksResource extends JsonResource
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
            'marksGrade_id'=>$this->id,
            'marks_exam_id' => $this->exam_id,
            'marks_grade_name' => $this->grade_name,
            'percentage_from' => $this->percentage_from,
            'percentage_upto' => $this->percentage_upto,
            'comment' => $this->comment,
        ];
    }
}
