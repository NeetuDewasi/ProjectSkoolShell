<?php

namespace App\Http\Resources\School\Common;

use App\Http\Resources\School\Academics\SchoolSectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassListResource extends JsonResource
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
            'name' => $this->name,
        ];
    }
}
