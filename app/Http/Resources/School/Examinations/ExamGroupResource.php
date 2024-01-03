<?php

namespace App\Http\Resources\School\Examinations;

use App\Http\Resources\School\Academics\SchoolClassResource;
use App\Http\Resources\School\Common\ClassListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamGroupResource extends JsonResource
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
            'examGroup_id'=>$this->id,
            'school_class_id' => $this->school_class_id,
            'school_class' => new ClassListResource($this->schoolClass) ,
            'examGroup_name'=>$this->group_name,
            'examGroup_type'=>$this->examType,
            'examGroup_description'=>$this->description,
        ];
    }
}
