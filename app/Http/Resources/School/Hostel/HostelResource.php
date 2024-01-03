<?php

namespace App\Http\Resources\School\Hostel;

use Illuminate\Http\Resources\Json\JsonResource;

class HostelResource extends JsonResource
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
            'hostel_id' => $this->id,
            'hostel_name' => $this->hostel_name,
            'hostel_type' => $this->type,
            'hostel_intake' => $this->intake,
            'hostel_person' => $this->contact_person,
            'hostel_number' => $this->contact_number,
            'hostel_alt_number' => $this->alternative_contact_number,
            'hostel_email' => $this->email,
            'hostel_address_line1' => $this->address_line1,
            'hostel_address_line2' => $this->address_line2,
            'hostel_area' => $this->area,
            'hostel_landmark' => $this->landmark,
            'hostel_city' => $this->city,
            'hostel_state' => $this->state,
            'hostel_country' => $this->country,
            'hostel_pincode' => $this->pincode,
            'hostel_description' => $this->description,
            'hostel_status' => $this->status,
        ];
    }
}
