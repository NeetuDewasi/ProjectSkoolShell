<?php

namespace App\Http\Resources\School\Inventory;

use Illuminate\Http\Resources\Json\JsonResource;

class AddItemResource extends JsonResource
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
            'category' =>new ItemCategoryDropDownResource($this->itemCategory),
            'item_name' => $this->item_name,
        ];
    }
}
