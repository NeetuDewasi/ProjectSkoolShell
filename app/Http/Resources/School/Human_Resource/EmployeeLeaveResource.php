<?php

namespace App\Http\Resources\School\Human_Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeLeaveResource extends JsonResource
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
            'employee' => new EmployeeResource($this->employee),
            'leave_type_id' => $this->leave_type_id,
            'leave_from' => $this->leave_from,
            'leave_to' => $this->leave_to,
            'leave_reason' => $this->leave_reason,
            'documents' => $this->documents,
            'response_by' => new EmployeeResource($this->response_by),
            'response_at' => $this->response_at,
            'response_message' => $this->response_message,
            'status' => $this->status,
        ];
    }
}
