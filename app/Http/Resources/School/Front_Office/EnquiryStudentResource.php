<?php

namespace App\Http\Resources\School\Front_Office;

use App\Http\Resources\School\Common\ClassListResource;
use App\Http\Resources\school\Front_Office\AdmissionEnquiryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EnquiryStudentResource extends JsonResource
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
            'enquiry_student_id' => $this->id,
            'enquiry_admission_id' => $this->admission_enquiry_id,
            'enquiry_student_class' => new ClassListResource($this->schoolClass),
            'enquiry_student_name' => $this->name,
            'admission_enquiry' => new AdmissionEnquiryResource($this->admissionEnquiry),
            'enquiry_student_status' => $this->status,
        ];
    }
}
