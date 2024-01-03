<?php

namespace App\Http\Resources\School\Expenses;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseHeadResource extends JsonResource
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
            'expense_head_id' => $this->id,
            'expense_head_name' => $this->name,
            'expense_head_description' => $this->description,
            'expense_head_status' => $this->status,
        ];
    }
}
