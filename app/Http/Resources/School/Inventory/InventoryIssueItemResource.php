<?php

namespace App\Http\Resources\School\Inventory;

use App\Http\Resources\School\Human_Resource\DepartmentResource;
use App\Http\Resources\School\Human_Resource\EmployeeResource;
use App\Http\Resources\School\Inventory\ItemStockDropDownResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryIssueItemResource extends JsonResource
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
            'inventory_issueItem_id' => $this->id,
            'login_user_id' => $this->login_user_id,
            'inventory_item_category_id' => new ItemCategoryDropDownResource($this->inventoryItemCategory),
            'inventory_add_item_id' => new ItemDropDownResource($this->inventoryAddItem),
            'inventory_department_info_id' => new ItemDepartmentDropDownResource($this->departments),
            'inventory_employee_id' => new EmployeeDropDownResource($this->employees),
            // 'quantity' => new ItemStockDropDownResource($this->inventory_add_item_stocks),
            'quantity' => (int) $this->quantity,
            'return_date' => $this->return_date,
            'description' => $this->description,
        ];
    }
}
