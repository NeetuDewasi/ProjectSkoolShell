<?php

namespace App\Http\Controllers\School\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Inventory\AddItemResource;
use App\Http\Resources\School\Inventory\InventoryItemCategoryResources;
use App\Http\Resources\School\Inventory\ItemCategoryDropDownResource;
use App\Models\InventoryAddItem;
use App\Models\InventoryItemCategory;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function getData()
    {
        $InventoryAddItem = InventoryAddItem::where('school_id', 1)->get();
        $itemCategories = InventoryItemCategory::where('school_id', 1)->get();
        if (count($itemCategories) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'item_category' => AddItemResource::collection($InventoryAddItem),
            'item_categories' => ItemCategoryDropDownResource::collection($itemCategories)
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'item_category' => null,
            'message' => 'No income head created yet'
        ]);
    }
    public function saveData(Request $request)
    {
        $InventoryAddItem = InventoryAddItem::where('item_name', $request->item_name)->where('school_id', 1)->first();

        if ($InventoryAddItem) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Item is already exist'
        ]);

        $created = InventoryAddItem::create([
            'school_id' => 1,
            'item_name' => $request->item_name,
            'category_id' => $request->item_category,
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Inventory item created successfully',
                'item_category' => new AddItemResource($created),

            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Inventory item',
        ]);
    }

    public function getEditData(InventoryAddItem $InventoryAddItem)
    {
        return response([
            'status' => 'success',
            'item_category' => new InventoryItemCategoryResources($InventoryAddItem),
        ]);
    }

    public function updateData(Request $request, InventoryAddItem $InventoryAddItem)
    {
        $updated = $InventoryAddItem->update([
            'school_id' => 1,
            'item_name' => $request->item_name,
            'category_id' => $request->item_category,


        ]);
        if ($updated) {
            $updatedItem = InventoryAddItem::find($InventoryAddItem->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Inventory Item  updated successfully',
                'item_category' => new AddItemResource($updatedItem),

            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create inventory item ',
        ]);
    }

    public function deleteData(InventoryAddItem $InventoryAddItem)
    {
        $deleted = $InventoryAddItem->delete();
        if ($deleted) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => ' inventory item deleted successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create item ',
        ]);
    }
}
