<?php

namespace App\Http\Resources\Admin\School;

use App\Http\Resources\Admin\SchoolGroup\SchoolGroupResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
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
            'school_id'=>$this->id,
            'group_id'=>$this->school_group_id,
            'group'=>new SchoolGroupResource($this->schoolGroup),
            'school_name'=>$this->name,
            'contact_person_name'=>$this->contact_person_name,
            'mobile_number'=>$this->mobile,
            'alternative_mobile_number'=>$this->alternative_mobile,
            'email_id'=>$this->email,
            'alternative_email_id'=>$this->alternative_email,
            'current' => [
                'current_address_line1'=>$this->current_address_line1,
                'current_address_line2'=>$this->current_address_line2,
                'current_location'=>$this->current_location,
                'current_landmark'=>$this->current_landmark,
                'current_city'=>$this->current_city,
                'current_pincode'=>$this->current_pincode,
                'current_state'=>$this->current_state,
                'current_country'=>$this->current_country,
            ],
            'permanent' => [
                'permanent_address_line1' => $this->permanent_address_line1,
                'permanent_address_line2' => $this->permanent_address_line2,
                'permanent_location' => $this->permanent_location,
                'permanent_landmark' => $this->permanent_landmark,
                'permanent_city' => $this->permanent_city,
                'permanent_pincode' => $this->permanent_pincode,
                'permanent_state' => $this->permanent_state,
                'permanent_country' => $this->permanent_country,
            ],
            'status'=>$this->status,
            'is_permanent' => $this->is_same_address,
            'password' => $this->password_text
        ];
    }
}
