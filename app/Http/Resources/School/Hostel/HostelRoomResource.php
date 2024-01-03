<?php

namespace App\Http\Resources\School\Hostel;

use Illuminate\Http\Resources\Json\JsonResource;

class HostelRoomResource extends JsonResource
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
            'hostel_room_id' => $this->id,
            'hostel_room_hostel' => new HostelListResource($this->hostel),
            'hostel_room_type' => new RoomTypeListResource($this->roomType),
            'hostel_room_name' => $this->room_name,
            'hostel_room_no_of_bed' => $this->number_of_bed,
            'hostel_room_cost' => $this->cost_per_bed,
            'hostel_room_description' => $this->description,
            'hostel_room_status' => $this->status,
        ];
    }
}
