<?php

namespace App\Http\Resources\School\Examinations;

use App\Http\Resources\School\Student\StudentAdmissionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResultResource extends JsonResource
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
            'examResult_id'=>$this->id,
            'students'=>new StudentAdmissionResource(),
        ];
    }
}
