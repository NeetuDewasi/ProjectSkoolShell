<?php

namespace App\Http\Controllers\School\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\School\Inventory\InventoryItemCategoryResources;
use App\Http\Resources\School\Inventory\InventoryIssueItemResource;
use App\Http\Resources\School\Inventory\ItemCategoryDropDownResource;
use App\Http\Resources\School\Inventory\ItemDropDownResource;
use App\Http\Resources\School\Inventory\ItemStockDropDownResource;
use App\Http\Resources\School\Inventory\EmployeeDropDownResource;
use App\Http\Resources\School\Inventory\ItemDepartmentDropDownResource;
use App\Models\InventoryAddItem;
use App\Models\InventoryIssueItem;
use App\Models\InventoryItemCategory;
use App\Models\Employee;
use App\Models\Department;
use App\Models\InventoryAddItemStock;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ItemIssueController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $issueItems = InventoryIssueItem::where('school_id', $activeSchool->id)->get();
        $itemCategories = InventoryItemCategory::where('school_id', $activeSchool->id)->get();
        $departments = Department::where('school_id', $activeSchool->id)->get();
        if (count($itemCategories) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'issue_items' => InventoryIssueItemResource::collection($issueItems),
            'item_categories' => ItemCategoryDropDownResource::collection($itemCategories),
            'departments' => ItemDepartmentDropDownResource::collection($departments),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'issue_items' => null,
            'message' => 'No Inventory Issue Item add yet..',
        ]);
    }
    public function getItemCategoryData(Request $request)
    {
        $inventoryitemcategorys = InventoryItemCategory::where('item_category', $request->item_category)->where('school_id', 1)->first();

        if ($inventoryitemcategorys && count($inventoryitemcategorys) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'IssueItemList' => InventoryItemCategoryResources::collection($inventoryitemcategorys),
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
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $created = InventoryIssueItem::create([
            'school_id' => $activeSchool->id,
            'login_user_id' => $user->id,
            'inventory_item_category_id' => $request->inventory_item_category_id,
            'inventory_add_item_id' => $request->inventory_add_item_id,
            'inventory_item_department_id' => $request->inventory_item_department_id,
            'inventory_item_employee_id' => $request->inventory_item_employee_id,
            'quantity' => (int) $request->quantity,
            'return_date' => $request->return_date,
            'description' => $request->description,
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Inventory Issue Item Created Successfully',
                'issue_items' => new InventoryIssueItemResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Inventory Item',
        ]);
    }

    public function getEditData(InventoryIssueItem $inventoryIssueItem)
    {
        return response([
            'status' => 'success',
            'issue_items' => new InventoryIssueItemResource($inventoryIssueItem),
        ]);
    }

    public function getItems(InventoryItemCategory $inventoryItemCategory)
    {
        $items = InventoryAddItem::where('category_id', $inventoryItemCategory->id)->where('school_id', 1)->with('stocks')->with('remainstocks')->get();

        if ($items && count($items)  > 0) return response([
            'status' => 'success',
            'message' => '',
            'itemsName' => ItemDropDownResource::collection($items),
        ]);
        return response([
            'status' => 'success',
            'message' => 'No Data Found',
            'itemsName' => null,
        ]);
    }

    // public function getItemStocks(InventoryAddItemStock $inventory_add_item_stock)
    // {
    //     $itemstocks = InventoryAddItemStock::where('inventory_add_item_id', $inventory_add_item_stock->id)->where('school_id', 1)->SUM('quantity')->get();
    //     $itemquantity = InventoryAddItemStock::SUM('quantity')->where('inventory_add_item_id', $inventory_add_item_stock->id)->get();

    //     if ($itemstocks && count($itemstocks) || $itemquantity && count($itemquantity)> 0) return response([
    //         'status' => 'success',
    //         'message' => '',
    //         'itemsStock' => ItemStockDropDownResource::collection($itemstocks),
    //         'ItemAvailStock'=> ItemStockDropDownResource::collection($itemquantity),
    //     ]);


    //     return response([
    //         'status' => 'success',
    //         'message' => 'No Data Found',
    //         'itemsStock' => null,
    //     ]);


    // }

    public function getEmployees($id)
    {
        $items = Employee::where('department_id', $id)->where('school_id', 1)->get();
        if ($items && count($items) > 0) return response([
            'status' => 'success',
            'message' => '',
            'employeeList' => EmployeeDropDownResource::collection($items),
        ]);

        return response([
            'status' => 'success',
            'message' => 'No Data Found',
            'employeeList' => null,
        ]);
    }

    public function updateData(Request $request, InventoryIssueItem $inventory_issue_item)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $update = $inventory_issue_item->update([
            'school_id' => $activeSchool->id,
            'login_user_id' => $user->id,
            'inventory_item_category_id' =>  $request->inventory_item_category_id,
            'inventory_add_item_id' => $request->inventory_add_item_id,
            'inventory_item_department_id' =>  $request->inventory_item_department_id,
            'inventory_item_employee_id' =>  $request->inventory_item_employee_id,
            'quantity' => (int) $request->quantity,
            'return_date' => $request->return_date,
            'description' => $request->description,
        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Inventory Issue Item Updated Successfully',
                'issue_items' => $update,
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Store Item',
        ]);
    }
    public function deleteData(InventoryIssueItem $InventoryIssueItem)
    {
        $deleted = $InventoryIssueItem->delete();
        if ($deleted) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => ' inventory Issue item deleted successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create item ',
        ]);
    }
};
