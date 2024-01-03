<?php

namespace App\Http\Resources\School\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentAddressResource extends JsonResource
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
            'address_id' => $this->address_id,
            'school_id' => $this->school_id,
            'admission_id' => $this->admission_id,
            'is_current' => $this->isCurrent,
            'current' => [
                'address_line1' => $this->current_address_line1,
                'address_line2' => $this->current_address_line2,
                'location' => $this->current_location,
                'landmark' => $this->current_landmark,
                'city' => $this->current_city,
                'pincode' => $this->current_pincode,
                'state' => $this->current_state,
                'country' => $this->current_country,
            ],
            'is_permanent' => $this->isPermanent,
            'permanent' => [
                'address_line1' => $this->permanent_address_line1,
                'address_line2' => $this->permanent_address_line2,
                'location' => $this->permanent_location,
                'landmark' => $this->permanent_landmark,
                'city' => $this->permanent_city,
                'pincode' => $this->permanent_pincode,
                'state' => $this->permanent_state,
                'country' => $this->permanent_country,
            ],
            'status' => $this->status,
        ];
    }
}
