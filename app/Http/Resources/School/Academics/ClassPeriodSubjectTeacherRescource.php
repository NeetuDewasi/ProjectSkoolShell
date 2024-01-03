<?php

namespace App\Http\Resources\School\Academics;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassPeriodSubjectTeacherRescource extends JsonResource
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
            'id' => $this->id,
            'school_class' => new SchoolClassResource($this->schoolClass),
            'school_section' => new SchoolSectionResource($this->schoolSection),
            'periods' => new ClassPeriodResource($this->periods),
            'subjects' => new SubjectResource($this->subject),
            'day' => $this->day
        ];
    }
}
