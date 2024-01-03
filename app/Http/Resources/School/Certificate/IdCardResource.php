<?php

namespace App\Http\Resources\School\Certificate;

use Illuminate\Http\Resources\Json\JsonResource;

class IdCardResource extends JsonResource
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
            'idCard_id'=>$this->id,
            'id_school_name'=>$this->school_name,
            'id_title'=>$this->id_card_title,
            'id_header_color'=>$this->header_color,
            'address_phone_email'=> $this->address,
            'id_admission_number'=> $this->admission_number,
            'id_student_name'=> $this->student_name,
            'id_class'=> $this->class,
            'id_father_name'=> $this->father_name,
            'id_mother_name' => $this->mother_name,
            'id_address' => $this->student_address,
            'id_phone_number' => $this->phone_number,
            'id_date_of_birth' => $this->date_of_birth,
            'id_blood_group' => $this->blood_group,
            'student_photo' => $this->student_photo,
            'idCard_background_image'=>$this->background_image,
            'idCard_signature' => $this->signature,
            'idCard_logo' => $this->logo,
            'idCard_status' => $this->status,
        ];
    }
}
