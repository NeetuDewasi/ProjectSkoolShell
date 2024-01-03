<?php

namespace App\Http\Controllers\School\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Inventory\AddItemDropdownResource;
use Illuminate\Http\Request;
use App\Http\Resources\School\Inventory\InventoryItemCategoryResources;
use App\Http\Resources\School\Inventory\InventoryStockItemResource;
use App\Http\Resources\School\Inventory\ItemCategoryDropDownResource;
use App\Http\Resources\School\Inventory\ItemDropDownResource;
use App\Http\Resources\School\Inventory\ItemStoreDropDownResource;
use App\Http\Resources\School\Inventory\ItemSupplierDropDownResource;
use App\Models\InventoryAddItem;
use App\Models\InventoryAddItemStock;
use App\Models\InventoryItemCategory;
use App\Models\InventoryItemStore;
use App\Models\InventorySupplierInfo;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ItemStockController extends Controller
{
    public function getData()
    {
        $expenses = InventoryAddItemStock::where('school_id', 1)->get();
        $itemCategories = InventoryItemCategory::where('school_id', 1)->get();
        if (count($itemCategories) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'stock_items' => InventoryStockItemResource::collection($expenses),
            'item_categories' => ItemCategoryDropDownResource::collection($itemCategories)
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'itemstock' => null,
            'message' => 'No Inventory Stock Item add yet..',
        ]);
    }
    public function getItemCategoryData(Request $request)
    {
        $inventoryitemcategorys = InventoryItemCategory::where('item_category', $request->item_category)->where('school_id', 1)->first();

        if ($inventoryitemcategorys && count($inventoryitemcategorys) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'StockItemList' => InventoryItemCategoryResources::collection($inventoryitemcategorys),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'expense_heads' => null,
            'message' => 'No Inventory Item Category add yet ..',
        ]);
    }
    public function saveData(Request $request)
    {
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $image = '';
        if ($request->has('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('Inventory/images');
        }
        $created = inventoryadditemstock::create([
            'school_id' => $activeSchool->id,
            'inventory_item_category_id' =>  $request->inventory_item_category_id,
            'inventory_add_item_id' => $request->inventory_add_item_id,
            'inventory_supplier_info_id' =>  $request->inventory_supplier_info_id,
            'inventory_item_store_id' =>  $request->inventory_item_store_id,
            'quantity' => $request->quantity,
            'income_date' => $request->income_date,
            'description' => $request->description,
            'document' => $image
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Inventory Item Created Successfully',
                'stock_items' => new InventoryStockItemResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Inventory Item',
        ]);
    }

    public function getEditData(InventoryAddItemStock $InventoryAddItemStock)
    {
        return response([
            'status' => 'success',
            'stock_items' => new InventoryStockItemResource($InventoryAddItemStock),

        ]);
    }

    public function getDropdownData()
    {
        $suppliers = InventorySupplierInfo::get();
        $stores = InventoryItemStore::get();
        if($suppliers ||$stores) return response([
            'status' => 'success',
            'message' => '',
            'itemSuppliers' => ItemSupplierDropDownResource::collection($suppliers),
            'itemStores' => ItemStoreDropDownResource::collection($stores),
        ]);

        return response([
            'status' => 'error',
            'message' => 'No Data found',
            'itemSuppliers' =>null,
        ]);
    }


    public function getItems(InventoryItemCategory $inventoryItemCategory)
    {

        $items = InventoryAddItem::where('category_id', $inventoryItemCategory->id)->where('school_id', 1)->get();

        if ($items && count($items) > 0) return response([
            'status' => 'success',
            'message' => '',
            'itemsName' => AddItemDropdownResource::collection($items),
        ]);

        return response([
            'status' => 'success',
           'message' => 'No Data Found',
            'itemsName' => null,
        ]);
    }

    public function getItemSuppliers(InventoryAddItem $inventoryAddItem)
    {
        return response([
            'status' => 'success',
            'message' => '',
            'itemSuppliers' => ItemSupplierDropDownResource::collection($inventoryAddItem->suppliers),

        ]);
    }
    public function getItemStores(InventorySupplierInfo $inventorySupplierInfo)
    {
        return response([
            'status' => 'success',
            'message' => '',
            'itemStores' => ItemStoreDropDownResource::collection($inventorySupplierInfo->stores),
        ]);
    }

    public function updateData($id, Request $request)
    {
        $inventory_add_item_stock = InventoryAddItemStock::where('id',$id)->first();

        $image = '';
            if ($request->hasFile('image') && $request->image != null && $request->image != '') {
                $image = '/storage/' . $request->image->store('Inventory/images');
            } else {
                $image = $inventory_add_item_stock->document;
            }

        $update = $inventory_add_item_stock->update([
            'school_id' => 1,
            'inventory_item_category_id' =>  $request->inventory_item_category_id,
            'inventory_add_item_id' => $request->inventory_add_item_id,
            'inventory_supplier_info_id' =>  $request->inventory_supplier_info_id,
            'inventory_item_store_id' =>  $request->inventory_item_store_id,
            'quantity' => $request->quantity,
            'income_date' => $request->income_date,
            'description' => $request->description,
            'document' => $image
        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Inventory Item Updated Successfully',
                'expenses' => $update,
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Store Item',
        ]);
    }
    public function deleteInventoryData($inventory_inventory_add_item_stock_id)
    {

        $inventoryAddItemStock = InventoryAddItemStock::find($inventory_inventory_add_item_stock_id);

            $deleted = $inventoryAddItemStock->delete();

            if ($deleted) {
                return response([
                    'status' => 'success',
                    'status_code' => 201,
                    'message' => 'Inventory item deleted successfully'
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'status_code' => 400,
                    'message' => 'Failed to delete the inventory item',
                ]);
            }

    }

};
