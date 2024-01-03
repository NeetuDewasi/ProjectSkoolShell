<?php

namespace App\Http\Resources\School\Hostel;

use App\Http\Resources\School\Hostel\HostelListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomTypeResource extends JsonResource
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
            'room_type_id' => $this->id,
            'room_hostel_id' => $this->hostel_id,
            'hostel_name'=> new HostelListResource($this->hostels),
            'room_type_name' => $this->room_type,
            'room_type_description' => $this->description,
            'room_type_status' => $this->status,
        ];
    }
}
