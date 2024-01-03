<?php

namespace App\Http\Resources\School\Examinations;

use Illuminate\Http\Resources\Json\JsonResource;

class DesignMarksheetResource extends JsonResource
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
            'marksheet_id'=>$this->id,
            'marksheet_template'=>$this->template,
            'marksheet_heading'=>$this->heading,
            'marksheet_title'=>$this->title,
            'marksheet_exam_id'=>$this->exam_id,
            'marksheet_school_name'=>$this->school_name,
            'marksheet_exam_center'=>$this->exam_center,
            'marksheet_body_text'=>$this->body_text,
            'marksheet_footer_text'=>$this->footer_text,
            'marksheet_printed_at'=>$this->printing_date,
            'marksheet_student_name'=>$this->student_name,
            'marksheet_father_name'=>$this->father_name,
            'marksheet_mother_name'=>$this->mother_name,
            'marksheet_exam_session'=>$this->exam_session,
            'marksheet_date_of_birth'=>$this->date_of_birth,
            'marksheet_admission_number'=>$this->admission_number,
            'marksheet_division'=>$this->division,
            'marksheet_roll_number'=>$this->roll_no,
            'marksheet_student_photo'=>$this->student_photo,
            'marksheet_class'=>$this->class,
            'marksheet_section'=>$this->section,
            'marksheet_remark'=>$this->remark,
            'marksheet_left_logo'=>$this->left_logo,
            'marksheet_right_logo'=>$this->right_logo,
            'marksheet_left_sign'=>$this->left_sign,
            'marksheet_middle_sign'=>$this->middle_sign,
            'marksheet_right_sign'=>$this->right_sign,
            'marksheet_background_image'=>$this->background_image
        ];
    }
}
