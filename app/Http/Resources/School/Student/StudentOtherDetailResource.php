<?php

namespace App\Http\Resources\School\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentOtherDetailResource extends JsonResource
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
            'student_other_detail' => $this->id,
            'school_id' => $this->school_id,
            'admission_id' => $this->admission_id,
            'national_identification_number' => $this->national_identification_number,
            'local_identification_number' => $this->local_identification_number,
            'rte' => $this->rte,
            'previous_school' => $this->previous_school,
            'note' => $this->note,
            'status' => $this->status,
        ];
    }
}
