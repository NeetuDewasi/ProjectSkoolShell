<?php

namespace App\Http\Resources\School\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class TransportResource extends JsonResource
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
            'route_id' => $this->id,
            'route_name' => $this->route_name,
            'route_status' => $this->status,
        ];
    }
}
