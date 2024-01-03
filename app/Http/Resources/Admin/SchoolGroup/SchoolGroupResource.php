<?php

namespace App\Http\Resources\Admin\SchoolGroup;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolGroupResource extends JsonResource
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
            'group_id'=>$this->id,
            'group_name'=>$this->name,
            'contact_person_name'=>$this->contact_person_name,
            'mobile_number'=>$this->mobile,
            'alternative_mobile_number'=>$this->alternative_mobile,
            'email_id'=>$this->email,
            'alternative_email_id'=>$this->alternative_email,
            'status'=>$this->status,
        ];
    }
}
