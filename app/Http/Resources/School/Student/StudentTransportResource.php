<?php

namespace App\Http\Resources\School\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentTransportResource extends JsonResource
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
            'student_transport_id' => $this->id,
            'transport_details' => new TransportResource($this->schoolRoute),
            'school_id' => $this->school_id,
            'admission_id' => $this->admission_id,
            'school_route_id' => $this->school_route_id,
            'status' => $this->status,
        ];
    }
}
