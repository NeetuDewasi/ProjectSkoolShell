<?php

namespace App\Http\Resources\School\Examinations;

use Illuminate\Http\Resources\Json\JsonResource;

class AdmitCardResource extends JsonResource
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
            'admitCard_id' => $this->id,
            'admit_template'=>$this->template,
            'admit_heading' => $this->heading,
            'admit_title' => $this->title,
            'admit_exam_id' => $this->exam_id,
            'admit_school_name' => $this->school_name,
            'admit_exam_center' => $this->exam_center,
            'admit_footer_text' => $this->footer_text,
            'admit_student_name' => $this->student_name,
            'admit_father_name' => $this->father_name,
            'admit_mother_name' => $this->mother_name,
            'admit_date_of_birth' => $this->date_of_birth,
            'admit_admission_number' => $this->admission_number,
            'admit_roll_number' => $this->roll_no,
            'admit_address' => $this->address,
            'admit_gender' => $this->gender,
            'admit_phone_number' => $this->phone_number,
            'admit_class' => $this->class,
            'admit_section' => $this->section,
            'admit_background_image' => $this->background_image,
            'admit_signature' => $this->signature,
            'admit_left_logo' => $this->left_logo,
            'admit_right_logo' => $this->right_logo,
            'admitCard_status' => $this->status,
        ];
    }
}
