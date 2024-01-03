<?php

namespace App\Http\Controllers\School\Income;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddIncomeInfo;
use App\Models\IncomeHead;
use App\Http\Resources\School\Income\AddIncomeResource;
use App\Http\Resources\School\Income\IncomeHeadDropDownResource;
use App\Http\Resources\School\Income\IncomeHeadResource;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SearchIncomeInfoController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $Incomes = AddIncomeInfo::where('school_id',$activeSchool->id)->with('incomeHead')->get();

        if (count($Incomes) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'incomes' => AddIncomeResource::collection($Incomes),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'incomes' => null,
            'message' => 'No More income information created yet'
        ]);
    }

    public function getIncomeHeadData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $IncomeHeads = IncomeHead::where('school_id',$activeSchool->id)->get();

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

    public function saveData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $Incomes = AddIncomeInfo::where('income_head', $request->income_head)->allowed()->where('school_id', 1)->first();
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
            'date' => $request->date,
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
                // if(Storage::has($AddIncomeInfo->document)) {
                //     Storage::delete($AddIncomeInfo->document);
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
            'income_head' =>  $request->income_head,
            'item_name' => $request->item_name,
            'invoice_number' => $request->invoice_number,
            'date' => $request->date,
            'amount' => $request->amount,
            'document' => $image,
            'description' => $request->description
        ]);
        if ($updated) {
            // $income = AddIncomeInfo::find($AddIncomeInfo->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Add income information updated successfully',
                // 'incomes' => new AddIncomeResource($income),
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
    public function getDataDetail(AddIncomeInfo $add_income_info)
    {
        return response([
            'status' => 'success',
            'income' => new AddIncomeResource($add_income_info),
        ]);
    }
    // public function changeStatusData(Request $request, AddIncomeInfo $addIncomeInfo)
    // {
    //     $update = $addIncomeInfo->update(['status' => $request->income_status]);
    //     if ($update) return response([
    //         'status' => 'success',
    //         'status_code' => 200,
    //         'message' => 'Expense data successfully ' . $request->income_status,
    //     ]);

    //     if ($request->income_status == 'activated') $message =
    //         'activate';
    //     else if ($request->income_status == 'deactivated') $message =
    //         'dectivate';
    //     else if ($request->income_status == 'deleted') $message = 'delete';

    //     return response([
    //         'status' => 'error',
    //         'status_code' => 400,
    //         'message' => 'Oops!! Something went wrong. Unable to ' . $message,
    //     ]);
    // }

}
