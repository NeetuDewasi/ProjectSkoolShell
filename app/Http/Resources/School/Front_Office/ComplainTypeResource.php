<?php

namespace App\Http\Resources\School\Front_Office;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplainTypeResource extends JsonResource
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
            'complain_type_id' => $this->id,
            'complain_type_name' => $this->title,
            'complain_type_description' => $this->description,
            'complain_type_status' => $this->status,
        ];
    }
}
