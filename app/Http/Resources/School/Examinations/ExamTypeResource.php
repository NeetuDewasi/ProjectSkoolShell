<?php

namespace App\Http\Resources\School\Examinations;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamTypeResource extends JsonResource
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
            'exam_type_id' => $this->id,
            'exam_type' => $this->name,
            'exam_description'=>$this->description,
            'status' => $this->status,
        ];

    }
}
