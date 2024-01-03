<?php

namespace App\Http\Resources\School\Transport;

use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignRouteResource extends JsonResource
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
            'assign_id' => $this->id,
            'driver' => new DriverListResource($this->driver),
            'vehicle' => new VehicleListResource($this->vehicle),
            'route' => new SchoolRoutesResource($this->route),
        ];
    }
}
