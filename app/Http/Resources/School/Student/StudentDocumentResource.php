<?php

namespace App\Http\Resources\School\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentDocumentResource extends JsonResource
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
            'school_id' => $this->school_id,
            'admission_id' => $this->admission_id,
            'title' => $this->title,
            'document' => $this->document,
            'status' => $this->state,
            'document_id' => $this->id,
        ];
    }
}
