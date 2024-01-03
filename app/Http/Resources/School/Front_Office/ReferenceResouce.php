<?php

namespace App\Http\Resources\School\Front_Office;

use Illuminate\Http\Resources\Json\JsonResource;

class ReferenceResouce extends JsonResource
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
            'reference_id' => $this->id,
            'reference_name' => $this->name,
            'reference_description' => $this->description,
            'reference_status' => $this->status,
        ];

    }
}
