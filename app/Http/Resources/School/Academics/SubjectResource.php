<?php

namespace App\Http\Resources\School\Academics;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
            'subject_id' => $this->id,
            'subject_name' => $this->name,
            'sub_code' => $this->subject_code,
            'subType' => $this->subject_type,
            'status' => $this->status
        ];
    }
}
