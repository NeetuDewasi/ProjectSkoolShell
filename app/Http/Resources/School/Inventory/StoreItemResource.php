<?php

namespace App\Http\Resources\School\Inventory;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreItemResource extends JsonResource
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
            'store_id' => $this->id,
            'item_store'=> $this->item_store,
            'item_stock'=> $this->item_stock,
            'description'=> $this->description


            ];
    }
}
