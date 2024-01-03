<?php

namespace App\Http\Controllers\School\FeeCollection;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Fees_Collection\AddFeesResource;
use App\Http\Resources\School\Fees_Collection\FeePaymentResource;
use App\Http\Resources\School\Fees_Collection\FeesDiscountDropDownResource;
use App\Http\Resources\School\Fees_Collection\FeesDiscountResource;
use App\Http\Resources\School\Fees_Collection\FeesMasterResource;
use App\Http\Resources\School\Fees_Collection\StudentAdmissionDropDownResource;
use App\Models\Admission;
use App\Models\Fee;
use App\Models\FeeDiscount;
use App\Models\FeeMaster;
use App\Models\FeesPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AddFeesController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $addfees= Fee::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($addfees) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'add_fees' =>FeesMasterResource::collection($addfees),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'add_fees' => null,
            'message' => 'No Fees add yet..',
        ]);
    }
    public function getAdmissionData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $studentAdmissions= Admission::where('school_id',$activeSchool->id)->allowed()->get();

        if($studentAdmissions && count($studentAdmissions) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'student_admission_list' => StudentAdmissionDropDownResource::collection($studentAdmissions),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_admission_list' => null,
            'message' => 'No Admission Data added yet..',
        ]);
    }
    public function getFeesDiscountData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $feeAmount = FeeMaster::where('id' , $request->fee_master)->allowed()->first();

        $today = Carbon::now();
        $fineDate = Carbon::createFromDate($feeAmount->due_date);


        $fineAmount = 0;
        if($today->gt($fineDate)) {
            if($feeAmount->fine_type == 'percantage') {
                if($feeAmount->fine_amount != null) {
                    $fa = (float) $feeAmount->fine_amount;
                    $fineAmount = ($fa /100) * (float) $feeAmount->amount;
                }
            } else {
                if($feeAmount->fine_amount != null) {
                    $fineAmount = (float) $feeAmount->fine_amount;
                }
            }
        }

        $feesDiscount= FeeDiscount::where('school_id',$activeSchool->id)->allowed()->get();
        if($feesDiscount && count($feesDiscount) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'fees_discount_list' => FeesDiscountDropDownResource::collection($feesDiscount),
            'amount' => $feeAmount ? $feeAmount->amount : '',
            // 'amount' => $feeAmount,
            'fine_amount' => $fineAmount,
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'fees_discount_list' => null,
            'message' => 'No Fees Discount added yet..',
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

        $addFees = Fee::where('admission_id', $request->fees_admission_id)->where('fees_master_id', $request->fees_master_id)->first();


        if(!$addFees) {
            $created = Fee::create([
                'school_id'=> $activeSchool->id,
                'admission_id' => $request->fees_admission_id,
                'fee_discount_id' => $request->fees_discount_id,
                'fees_master_id' => $request->fees_master_id,
                'date' =>  date_format(date_create($request->fees_date), 'Y-m-d'),
                'amount' =>  $request->fees_amount,
                'discount_amount' => $request->fees_discount_amount,
                'fine_amount' => $request->fees_fine_amount,
                'payment_mode' => $request->fees_payment_mode,
                'description' => $request->fees_description,
            ]);
            $createdFeeReceipt = FeesPayment::create([
                'school_id' => $activeSchool->id,
                'fees_master_id' =>  $request->fees_master_id,
                'fee_id' => $addFees->id,
                'admission_id' => $request->fees_admission_id,
                'receipt_number' => rand(1000000000, 9999999999),
                'invoice_number' => rand(1000000000, 9999999999),
                'amount_paid' => $request->fees_amount,
                'discount_amount' =>  $request->fees_discount_amount,
                'fine_amount' => $request->fees_fine_amount,
                'payment_mode' => $request->fees_payment_mode,
                'status' => 'unpaid',
            ]);

            $addFees = Fee::where('admission_id', $request->fees_admission_id)->where('fees_master_id', $request->fees_master_id)->first();

        } else {
            $createdFeeReceipt = FeesPayment::create([
                'school_id' => $activeSchool->id,
                'fees_master_id' =>  $request->fees_master_id,
                'fee_id' => $addFees->id,
                'admission_id' => $request->fees_admission_id,
                'receipt_number' => rand(1000000000, 9999999999),
                'invoice_number' => rand(1000000000, 9999999999),
                'amount_paid' => $request->fees_amount,
                'discount_amount' =>  $request->fees_discount_amount,
                'fine_amount' => $request->fees_fine_amount,
                'payment_mode' => $request->fees_payment_mode,
                'status' => 'unpaid',
            ]);
            $feePayments = FeesPayment::where('fees_master_id', $request->fees_master_id)->where('fee_id', $addFees->id)->get();

            $created = $addFees->update([
                'amount' => $feePayments->sum('amount_paid'),
                'discount_amount' => $feePayments->sum('discount_amount'),
                'fine_amount' => $feePayments->sum('fine_amount'),
            ]);


        }

        if($addFees){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Feesr Created Successfully',
                'add_fee' => new FeesMasterResource($addFees),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create fees',
        ]);
    }

    public function getEditData(Fee $fee)
    {
        return response([
            'status' => 'success',
            'add_fee' => new FeePaymentResource($fee),
        ]);
    }

    public function updateData(Request $request , Fee $fee)
    {

        $update = $fee->update([
            'fee_discount_id' => $request->fees_discount_id != -1 ? $request->fees_discount_id : null,
            'date' =>  date_format(date_create($request->fees_date), 'Y-m-d'),
            'amount' => $request->fees_amount  ,
            'payment_mode' => $request->fees_payment_mode,
            'description' => $request->fees_description,
        ]);

        if($update){
            $updateFees = Fee::find($fee->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Fees Updated Successfully',
                'add_fee' => new FeesMasterResource($updateFees),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Fees',
        ]);
    }

    public function changeStatusData(Request $request, Fee $addFee)
    {
        $update = $addFee->update(['status' => $request->fees_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Fees Master data successfully ' . $request->fees_status,
        ]);

        if ($request->fees_status == 'activated') $message =
            'activate';
        else if ($request->fees_status == 'deactivated') $message =
            'dectivate';
        else if ($request->fees_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
