<?php

namespace App\Http\Resources\School\Transport;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleRouteListResource extends JsonResource
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
            'assign_route' => new AssignVehicleListResource($this->assignRoute)
        ];
    }
}
