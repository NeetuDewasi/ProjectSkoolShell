<?php

namespace App\Http\Resources\School\Fees_Collection;

use Illuminate\Http\Resources\Json\JsonResource;

class FeesDiscountResource extends JsonResource
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
            'fees_discount_id' => $this->id,
            'fees_discount_name' => $this->name,
            'fees_discount_code' => $this->discount_code,
            'fees_discount_amount' => $this->amount,
            'fees_discount_description' => $this->description,
            'fees_discount_status' => $this->status,
        ];
    }
}
