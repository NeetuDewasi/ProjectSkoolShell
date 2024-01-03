<?php

namespace App\Http\Resources\School\Inventory;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemDropDownResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $qty = $this->stocks ? (int) $this->stocks->sum('quantity') : 0;
        $remainqty = $this->remainstocks ? (int) $this->remainstocks->sum('quantity') : 0;
       $quantity=(int)$qty-(int)$remainqty;
        return [
            'value' =>$this->id,
            'name' => $this->item_name . ' ('. $quantity .')',
            'quantity' =>(int)$quantity ,
        ];
    }
}
