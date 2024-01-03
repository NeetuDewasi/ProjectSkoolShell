<?php

namespace App\Http\Resources\School\Academics;


use Illuminate\Http\Resources\Json\JsonResource;

class SchoolClassResource extends JsonResource
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
            'class_id' => $this->id,
            'class_name' => $this->name,
            'class_number' => $this->number,
            'class_sections' => SchoolClassSectionResource::collection($this->schoolSections),
            'status' => $this->status,
        ];
    }
}
