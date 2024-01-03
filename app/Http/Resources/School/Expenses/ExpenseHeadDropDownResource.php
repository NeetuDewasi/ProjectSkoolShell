<?php

namespace App\Http\Resources\School\Expenses;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseHeadDropDownResource extends JsonResource
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
            'value' => $this->id,
            'name' => $this->name,
        ];
    }
}
