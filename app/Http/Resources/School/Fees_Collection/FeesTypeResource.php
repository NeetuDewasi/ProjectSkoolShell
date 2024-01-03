<?php

namespace App\Http\Resources\School\Fees_Collection;

use Illuminate\Http\Resources\Json\JsonResource;

class FeesTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'fees_type_id' => $this->id,
            'fees_type_name' => $this->name,
            'fees_type_fees_code' => $this->fees_code,
            'fees_type_description' => $this->description,
            'fees_type_status' => $this->status,
        ];
    }
}
