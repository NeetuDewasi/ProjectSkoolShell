<?php

namespace App\Http\Resources\School\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class HostelDropdownResource extends JsonResource
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
            'value' => $this->id,
            'name' => $this->hostel_name,
        ];
    }
}
