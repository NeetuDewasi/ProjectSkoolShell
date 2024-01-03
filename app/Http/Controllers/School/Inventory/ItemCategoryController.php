<?php

namespace App\Http\Controllers\School\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Inventory\InventoryItemCategoryResources;
use App\Models\InventoryItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{

    public function getData()
    {
        $InventoryItemCategory = InventoryItemCategory::where('school_id', 1)->get();
        if (count($InventoryItemCategory) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'item_categorys' => InventoryItemCategoryResources::collection($InventoryItemCategory),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'item_categorys' => null,
            'message' => 'No income head created yet'
        ]);
    }

    public function saveData(Request $request)
    {
        $InventoryItemCategory = InventoryItemCategory::where('item_category', $request->item_category)->where('school_id', 1)->first();

        if ($InventoryItemCategory) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This income head is already exist'
        ]);

        $created = InventoryItemCategory::create([
            'school_id' => 1,
            'item_category' => $request->item_category,
            'description' => $request->description,
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Inventory Category created successfully',
                'item_category' => new InventoryItemCategoryResources($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Inventory Category',
        ]);
    }

    public function getEditData(InventoryItemCategory $InventoryItemCategory)
    {
        return response([
            'status' => 'success',
            'item_categories' => $InventoryItemCategory,
        ]);
    }

    public function updateData(Request $request, InventoryItemCategory $InventoryItemCategory)
    {
        $updated = $InventoryItemCategory->update([
            'school_id' => 1,
            'item_category' => $request->item_category,
            'description' => $request->description,

        ]);
        if ($updated) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Inventory Item Category  updated successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create inventory item category',
        ]);
    }

    public function deleteData(InventoryItemCategory $InventoryItemCategory)
    {
        $deleted = $InventoryItemCategory->delete();
        if ($deleted) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => ' inventory item category deleted successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create item category',
        ]);
    }
}
