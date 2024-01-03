<?php

namespace App\Http\Controllers\School\FeeCollection;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Fees_Collection\FeesDiscountResource;
use App\Models\FeeDiscount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FeesDiscountController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $feesdiscounts = FeeDiscount ::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($feesdiscounts) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'fees_discounts' =>FeesDiscountResource::collection($feesdiscounts),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'fees_discounts' => null,
            'message' => 'No Fees Discount Created Yet',
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
        $feesdiscount = FeeDiscount::where('name', $request->fees_discount_name)->where('school_id', $activeSchool->id)->allowed()->first();

        if($feesdiscount) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Fees Discount already exits'
        ]);

        $created = FeeDiscount::create([
            'school_id'=> $activeSchool->id,
            'name' =>  $request->fees_discount_name,
            'discount_code' =>  $request->fees_discount_code,
            'amount' => $request->fees_discount_amount,
            'description' => $request->fees_discount_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Fees Discount Created Successfully',
                'fees_discount' => new FeesDiscountResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create fees group',
        ]);
    }
    public function getEditData(FeeDiscount $feesDiscount)
    {
        return response([
            'status' => 'success',
            'fees_discount' => new FeesDiscountResource($feesDiscount),
        ]);
    }

    public function updateData(Request $request , FeeDiscount $feesDiscount)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = FeeDiscount::where('name', $request->fees_discount_name)->where('school_id', $activeSchool->id)->where('id', '!=', $feesDiscount->id)->allowed()->first();
        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Fees Discount already exits'
        ]);
        $update = $feesDiscount->update([
            'name' =>  $request->fees_discount_name,
            'discount_code' =>  $request->fees_discount_code,
            'amount' => $request->fees_discount_amount,
            'description' => $request->fees_discount_description,

        ]);

        if($update){
            $updateFeeDiscount = FeeDiscount::find($feesDiscount->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Fees Discount Updated Successfully',
                'fees_discount' => new FeesDiscountResource($updateFeeDiscount),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Fees Discount',
        ]);
    }

    public function changeStatusData(Request $request, FeeDiscount $feesDiscount)
    {
        $update = $feesDiscount->update(['status' => $request->fees_discount_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Fees Discount data successfully ' . $request->fees_discount_status,
        ]);

        if ($request->fees_discount_status == 'activated') $message =
            'activate';
        else if ($request->fees_discount_status == 'deactivated') $message =
            'dectivate';
        else if ($request->fees_discount_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
