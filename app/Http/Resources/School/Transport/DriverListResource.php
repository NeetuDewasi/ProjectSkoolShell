<?php

namespace App\Http\Resources\School\Transport;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverListResource extends JsonResource
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
            'name' => $this->first_name . " " . $this->last_name
        ];
    }
}
