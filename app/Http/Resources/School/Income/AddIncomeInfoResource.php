<?php

namespace App\Http\Resources\School\Income;

use Illuminate\Http\Resources\Json\JsonResource;

class AddIncomeInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'disabled_staff_name' => $this->disabled_staff_name,
            'description' => $this->description,

        ];
    }
}
