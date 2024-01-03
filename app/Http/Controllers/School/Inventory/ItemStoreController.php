<?php

namespace App\Http\Controllers\School\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItemStore;
use App\Http\Resources\School\Inventory\StoreItemResource;

use Illuminate\Support\Facades\Log;

class ItemStoreController extends Controller
{
    public function getData()
    {
        $InventoryItemStores = InventoryItemStore::where('school_id', 1)->get();
        if(count($InventoryItemStores) > 0) return response([
                'status' => 'success',
                'status_code' => 200,
                'item_stores' =>StoreItemResource::collection($InventoryItemStores),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'item_stores' => null,
            'message' => 'No income head created yet'
        ]);
    }

    public function saveData(Request $request)
    {
        $InventoryItemStores = InventoryItemStore::where('item_store', $request->item_store)->where('school_id', 1)->first();

        if($InventoryItemStores) return response([

            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This income head is already exist'
        ]);

        $created = InventoryItemStore::create([
            'school_id' => 1,
            'item_store' => $request->item_store,
            'item_stock' => $request->item_stock,
            'description' => $request->description
        ]);

        if($created) {
            $storeitem=InventoryItemStore::find($created->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Supplier created successfully',
                'item_stores' => new StoreItemResource($storeitem),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create income head',
        ]);
    }

    public function getEditData(InventoryItemStore $InventoryItemStore)
    {
        return response([
            'status' => 'success',
            'item_stores' => $InventoryItemStore,
        ]);
    }

    public function updateData(Request $request, InventoryItemStore $InventoryItemStore)
    {
        $updated = $InventoryItemStore->update([
            'school_id' => 1,
            'item_store' => $request->item_store,
            'item_stock' => $request->item_stock,
            'description' => $request->description

        ]);
        if($updated) { return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Store Item head updated successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Store Item',
        ]);
    }

    public function deleteData(InventoryItemStore $InventoryItemStore)
    {
        $deleted = $InventoryItemStore->delete();
        if($deleted) { return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Store Item deleted successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Store Item',
        ]);

    }
}
