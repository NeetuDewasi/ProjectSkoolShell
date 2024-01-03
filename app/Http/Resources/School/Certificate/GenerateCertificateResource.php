<?php

namespace App\Http\Resources\school\Certificate;

use Illuminate\Http\Resources\Json\JsonResource;

class GenerateCertificateResource extends JsonResource
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
            'generateCertificate_id'=>$this->id,
            'certificate_class_id'=>$this->class_id,
            'certificate_section_id'=>$this->section_id,
            'certificate_admission_id'=>$this->admission_id,
            'certificate_id'=>$this->certificate_id,
        ];
    }
}
