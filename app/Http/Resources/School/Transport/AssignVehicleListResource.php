<?php

namespace App\Http\Resources\School\Transport;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignVehicleListResource extends JsonResource
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
            'vehicle_name' => $this->vehicle_model . ' ' . $this->registration_no,
            'assign_route' => new AssignRouteResource($this->latestRoute),
        ];
    }
}
