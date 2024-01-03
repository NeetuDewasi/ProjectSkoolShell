<?php

namespace App\Http\Resources\school\Front_Office;

use App\Http\Resources\School\Common\ClassListResource;
use App\Http\Resources\School\Front_Office\EnquiryStudentResource;
use App\Http\Resources\School\Front_Office\EnquiryStudentUpdateResource;
use App\Http\Resources\School\Front_Office\ReferenceDropDownResouce;
use App\Http\Resources\School\Front_Office\SourceDropDownResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionEnquiryResource extends JsonResource
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
            'admission_enquiry_id' => $this->id,
            'admission_enquiry_name' => $this->name,
            'admission_enquiry_phone' => $this->phone,
            'admission_enquiry_email' => $this->email,
            'admission_enquiry_address_line1' => $this->address_line1,
            'admission_enquiry_address_line2' => $this->address_line2,
            'admission_enquiry_area' => $this->area,
            'admission_enquiry_location' => $this->location,
            'admission_enquiry_landmark' => $this->landmark,
            'admission_enquiry_city' => $this->city,
            'admission_enquiry_state' => $this->state,
            'admission_enquiry_country' => $this->country,
            'admission_enquiry_pincode' => $this->pincode,
            'admission_enquiry_note' => $this->note,
            'admission_enquiry_no_of_child' => $this->no_of_child,
            'admission_enquiry_status' => $this->status,
            'students' => EnquiryStudentUpdateResource::collection($this->students),
        ];
    }
}
