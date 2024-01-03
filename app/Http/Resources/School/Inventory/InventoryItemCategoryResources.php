<?php

namespace App\Http\Resources\School\Inventory;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemCategoryResources extends JsonResource
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
            'item_id' => $this->id,
            'item_category' =>$this->item_category,
            'description' => $this->description,

        ];
    }
}
