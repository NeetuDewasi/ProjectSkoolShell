<?php

namespace App\Http\Resources\School\Inventory;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryStockItemResource extends JsonResource
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
            'stock_id' => $this->id,
            'inventory_item_category_id' => new ItemCategoryDropDownResource($this->inventoryItemCategory),
            'inventory_add_item_id' => new ItemDropDownResource($this->inventoryAddItem),
            'inventory_supplier_info_id' => new ItemSupplierDropDownResource($this->inventorySupplierInfo),
            'inventory_item_storeId' => new InventoryItemStoreDropdownResource($this->inventoryItemStore),
            'quantity' => $this->quantity,
            'income_date' => $this->income_date,
            'description' => $this->description,
            'document' => $this->document,
        ];
    }
}
