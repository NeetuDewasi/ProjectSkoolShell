<?php

namespace App\Http\Resources\School\Human_Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'department_id' => $this->id,
            'department_name' => $this->name,
            'department_status' => $this->status,
        ];
    }
}
