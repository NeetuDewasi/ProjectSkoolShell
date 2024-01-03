<?php

namespace App\Http\Resources\School\Communication;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeListDropdownResource extends JsonResource
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
            'employee_f_name' => $this->first_name,
            'employee_l_name' => $this->last_name,
            'employee_department' => $this->department_id,
        ];
    }
}
