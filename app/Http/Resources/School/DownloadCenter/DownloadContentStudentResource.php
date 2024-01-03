<?php

namespace App\Http\Resources\School\DownloadCenter;

use App\Http\Resources\School\Student\StudentCategoryResource;
use App\Http\Resources\School\Student\StudentGuardianResource;
use Illuminate\Http\Resources\Json\JsonResource;
class DownloadContentStudentResource extends JsonResource
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
            'student_admission_id' => $this->id,
            'student_admission_number' => $this->admission_number,
            'student_first_name' => $this->first_name,
            'student_middle_name' => $this->middle_name,
            'student_last_name' => $this->last_name,
            'evaluation_date' => $this->evaluation_date,
            'student_guardian' => new StudentGuardianResource($this->studentGuardian),
            'student_category' => new StudentCategoryResource($this->studentCategory),
        ];
    }
}
