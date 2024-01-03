<?php

namespace App\Http\Resources\School\Front_Office;

use Illuminate\Http\Resources\Json\JsonResource;

class SourceResource extends JsonResource
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
            'source_id' => $this->id,
            'source_name' => $this->name,
            'source_description' => $this->description,
            'source_status' => $this->status,
        ];
    }
}
