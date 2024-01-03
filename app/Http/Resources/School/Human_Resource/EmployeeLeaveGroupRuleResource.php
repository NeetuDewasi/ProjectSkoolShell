<?php

namespace App\Http\Resources\School\Human_Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeLeaveGroupRuleResource extends JsonResource
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
            'leave_group_rule_id' => $this->id,
            'leave_type_id' => $this->leave_type_id,
            'leave_group_id' => $this->leave_group_id,
            'leave' => (int) $this->leave,
            'status' => $this->status,
        ];
    }
}
