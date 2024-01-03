<?php

namespace App\Http\Resources\School\Common;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignedSubjectListResource extends JsonResource
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
            'value' => $this->subject->id,
            'name' => $this->subject->name,
        ];
    }
}
