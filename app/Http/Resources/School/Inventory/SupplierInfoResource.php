<?php

namespace App\Http\Resources\School\Inventory;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierInfoResource extends JsonResource
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
        'school_id' => $this->id,
        'supplier_name'=> $this->supplier_name,
        'email'=> $this->email,
        'address'=> $this->address,
        'phone'=> $this->phone,
        'contact_person_name'=> $this->contact_person_name,
        'contact_person_phone'=> $this->contact_person_phone,
        'contact_person_email'=> $this->contact_person_email,
        'description'=> $this->description

        ];
    }
}
