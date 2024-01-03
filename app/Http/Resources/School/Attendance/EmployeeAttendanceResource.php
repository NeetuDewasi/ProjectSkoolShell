<?php

namespace App\Http\Resources\School\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeAttendanceResource extends JsonResource
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
            'employee_id' => $this->id,
            'employee_registration_number' => $this->registration_id,
            'employee_department_name' => $this->department->name,
            'employee_first_name' => $this->first_name,
            'employee_last_name' => $this->last_name,
            'attendance' => $this->attendances && count($this->attendances) > 0 ? $this->attendances[0]->attendance : 1,
            'status' => $this->status
        ];
    }
}
