<?php

namespace App\Http\Resources\School\Inventory;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemResource extends JsonResource
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

            'school_id' => $this->id,
            'item_category'=> $this->item_category,
            'supplier'=> $this->supplier,
            'store'=> $this->store,
            'quantity'=> $this->quantity,
            'date'=> $this->date,
            'description'=> $this->description,
            'document'=> $this->document

        ];
    }
}
