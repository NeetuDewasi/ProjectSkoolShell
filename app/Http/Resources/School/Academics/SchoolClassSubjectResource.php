<?php

namespace App\Http\Resources\School\Academics;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolClassSubjectResource extends JsonResource
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
            'subject_name' => $this->subject->name,
            'teachers' => TeacherListResource::collection($this->subject->teachers),
            // 'selected_teacher' => '-1',
        ];
    }
}
