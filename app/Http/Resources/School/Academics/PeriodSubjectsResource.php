<?php

namespace App\Http\Resources\School\Academics;

use Illuminate\Http\Resources\Json\JsonResource;

class PeriodSubjectsResource extends JsonResource
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
            'subject_id' => $this->subject_id,
            'subject_name' => $this->subject ?  $this->subject->name : null,
            'teachers' => $this->subject ? TeacherListResource::collection($this->subject->teachers) : null,
            // 'selected_teacher' => $this->employee_id ? $this->employee_id : '-1',
        ];
    }
}
