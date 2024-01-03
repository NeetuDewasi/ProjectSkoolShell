<?php

namespace App\Http\Controllers\School\Income;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddIncomeInfo;
use App\Models\InventoryAddItem;
use App\Models\IncomeHead;
use App\Http\Resources\School\Income\AddIncomeResource;
use App\Http\Resources\School\Income\IncomeHeadDropDownResource;
use App\Http\Resources\School\Income\IncomeHeadResource;
use App\Http\Resources\School\Inventory\AddItemResource;
use App\Http\Resources\School\Inventory\ItemDropDownResource;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;

class AddIncomeInfoController extends Controller
{
    public function getData()
    {
        $Incomes = AddIncomeInfo::where('school_id', 1)->with('incomeHead')->get();
       $incomeItem = InventoryAddItem::where('school_id', 1)->get();


        if (count($Incomes) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'incomes' => AddIncomeResource::collection($Incomes),
           'IncomeItem' => AddItemResource::collection($incomeItem),



        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'incomes' => null,
            'IncomeItem' => null,
            'message' => 'No More income information created yet'
        ]);
    }

    public function getIncomeHeadData()
    {

        $IncomeHeads = IncomeHead::where('school_id', 1)->get();

        if ($IncomeHeads && count($IncomeHeads) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'income_head_list' => IncomeHeadDropDownResource::collection($IncomeHeads),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'income_head_list' => null,
            'message' => 'No Income Head added yet..',
        ]);
    }


    public function getIncomeItemData()
    {
        $items = InventoryAddItem::where('school_id', 1)->get();
        if ($items && count($items) > 0) return response([
            'status' => 'success',
            'message' => '',
            'income_item_list' => ItemDropDownResource::collection($items),
        ]);

        return response([
            'status' => 'success',
            'message' => 'No Data Found',
            'income_item_list' => null,
            'message' => 'No Income Head added yet..'
        ]);
    }

    public function saveData(Request $request)
    {
        $Incomes = AddIncomeInfo::where('id', $request->id)->where('school_id', 1)->first();
        if ($Incomes) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'income information is already exist'
        ]);
        $image = '';
        if ($request->has('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('Income/images');
        }
        $created = AddIncomeInfo::create([
            'school_id' => 1,
            'income_head' => $request->income_head,
            'item_name' => $request->item_name,
            'invoice_number' => $request->invoice_number,
            'date' => $request->income_date,
            'amount' => $request->amount,
            'document' => $image,
            'description' => $request->description
        ]);
        if ($created) {
            $Incomes = AddIncomeInfo::find($created->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Add income information created successfully',
                'incomes' => new AddIncomeResource($Incomes),

            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Disabled Staff ',
        ]);
    }
    public function getEditData(AddIncomeInfo $AddIncomeInfo)
    {
        return response([
            'status' => 'success',
            'incomes' => new AddIncomeResource($AddIncomeInfo),
        ]);
    }
    public function updateData(Request $request, AddIncomeInfo $add_income_info)
    {
        $image = '';
        if ($add_income_info->document != null &&  $add_income_info->document != '') {
            if ($request->has('image') && $request->image != null && $request->image != '') {
                // if(Storage::has($add_income_info->document)) {
                //     Storage::delete($add_income_info->document);
                // }
                $image = '/storage/' . $request->image->store('Income/images');
            } else {
                $image = $add_income_info->document;
            }
        } else {
            if ($request->has('image') && $request->image != null && $request->image != '') {
                $image = '/storage/' . $request->image->store('Income/images');
            } else {
                $image = $add_income_info->document;
            }
        }
        $updated = $add_income_info->update([
            'school_id' => 1,
            'income_head' => $request->income_head,
            'item_name' => $request->item_name,
            'invoice_number' => $request->invoice_number,
            'date' => $request->income_date,
            'amount' => $request->amount,
            'document' => $image,
            'description' => $request->description
        ]);
        if ($updated) {
            // $income = AddIncomeInfo::find($add_income_info->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Add income information updated successfully',
                //'incomes' => new AddIncomeResource($income),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create income head',
        ]);
    }
    public function deleteData(AddIncomeInfo $AddIncomeInfo)
    {
        $deleted = $AddIncomeInfo->delete();
        if ($deleted) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Add income information deleted successfully'
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create income head',
        ]);
    }
}
