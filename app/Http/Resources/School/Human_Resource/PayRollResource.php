<?php

namespace App\Http\Resources\School\Human_Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class PayRollResource extends JsonResource
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
            'payroll_id' => $this->id,
            'payroll_employee' => $this->employee_id,
            'payroll_epf_no' => $this->epf_no,
            'payroll_basic_salary' => $this->basic_salary,
            'payroll_contract_type' => $this->contract_type,
            'payroll_working_shift' => $this->working_shift,
            'payroll_location' => $this->location,
            'payroll_status' => $this->status,
        ];
    }
}
