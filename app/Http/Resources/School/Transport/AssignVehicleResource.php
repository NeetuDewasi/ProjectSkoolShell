<?php

namespace App\Http\Resources\School\Transport;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignVehicleResource extends JsonResource
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
            'vehicle_id' => $this->id,
            'school_route_id' => $this->route_name,
            'vehicle_no' => $this->vehicle_no,
            'driver_name' => $this->driver_name,
            'driver_license' => $this->driver_license,
            'phone' => $this->phone,
            'pickup_point' => $this->pickup_point,
            'position' => $this->position,
            'pickup_point_location' => $this->pickup_point_location,
        ];
    }
}
