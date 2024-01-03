<?php

namespace App\Http\Resources\School\Income;

use App\Http\Resources\School\Inventory\ItemDropDownResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AddIncomeResource extends JsonResource
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
            'income_head' => new IncomeHeadDropDownResource($this->incomeHead),
            'item_name' =>new ItemDropDownResource($this->incomeItem),
            'invoice_number' => $this->invoice_number,
            'income_date' => $this->date,
            'amount' => $this->amount,
            'document' => $this->document,
            'description' => $this->description,

        ];
    }
}
