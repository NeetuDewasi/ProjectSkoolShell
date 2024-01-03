<?php

namespace App\Http\Resources\School\Human_Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'employee_id' => $this->id,
            'employee_department' => new DepartmentDropDownResource($this->department),
            'employee_registration_id' => $this->registration_id,
            'employee_first_name' => $this->first_name,
            'employee_last_name' => $this->last_name,
            'employee_father_name' => $this->father_name,
            'employee_mother_name' => $this->mother_name,
            'employee_email' => $this->email,
            'employee_gender' => $this->gender,
            'employee_dob' => $this->dob,
            'employee_date_of_join' => $this->date_of_join,
            'employee_mobile' => $this->mobile,
            'employee_ecp' => $this->emergency_contact_name,
            'employee_ecn' => $this->emergency_contact_number,
            'employee_marital_status' => $this->marital_status,
            'employee_photo' => $this->photo,
            'current' => [
                'address_line1' => $this->current_address1,
                'address_line2' => $this->current_address2,
                'area' => $this->current_area,
                'location' => $this->current_location,
                'landmark' => $this->current_landmark,
                'city' => $this->current_city,
                'state' => $this->current_state,
                'country' => $this->current_country,
                'pincode' => $this->current_pincode,
            ],
            'is_same_address' => $this->is_same_address,
            'permanent' => [
                'address_line1' => $this->permanent_address1,
                'address_line2' => $this->permanent_address2,
                'area' => $this->permanent_area,
                'location' => $this->permanent_location,
                'landmark' => $this->permanent_landmark,
                'city' => $this->permanent_city,
                'state' => $this->permanent_state,
                'country' => $this->permanent_country,
                'pincode' => $this->permanent_pincode,
            ],
            'employee_status' => $this->status,
        ];
    }
}
