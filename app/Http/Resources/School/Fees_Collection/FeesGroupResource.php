<?php

namespace App\Http\Resources\School\Fees_Collection;

use App\Http\Resources\School\Common\ClassListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FeesGroupResource extends JsonResource
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
            'fees_group_id' => $this->id,
            'fees_class_id' => new ClassListResource($this->schoolClass),
            'fees_group_name' => $this->name,
            'fees_group_description' => $this->description,
            'fees_group_status' => $this->status,
        ];
    }
}
