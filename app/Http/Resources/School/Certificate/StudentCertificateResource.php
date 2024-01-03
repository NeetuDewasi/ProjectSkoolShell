<?php

namespace App\Http\Resources\school\Certificate;

use Illuminate\Http\Resources\Json\JsonResource;

use function Ramsey\Uuid\v1;

class StudentCertificateResource extends JsonResource
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
            'certificate_id' => $this->id,
            'student_certificate_name' => $this->certificate_name,
            'certificate_header_right_text' => $this->header_right_text,
            'certificate_header_center_text' => $this->header_center_text,
            'certificate_header_left_text' => $this->header_left_text,
            'certificate_body_text' => $this->body_text,
            'certificate_footer_right_text' => $this->footer_right_text,
            'certificate_footer_left_text' => $this->footer_left_text,
            'certificate_footer_center_text' => $this->footer_center_text,
            'certificate_header_height' => $this->header_height,
            'certificate_footer_height' => $this->footer_height,
            'certificate_body_width' => $this->body_width,
            'certificate_body_height' => $this->body_height,
            'certificate_student_photo' => $this->student_photo,
            'certificate_background_image' => $this->background_image,
        ];
    }
}
