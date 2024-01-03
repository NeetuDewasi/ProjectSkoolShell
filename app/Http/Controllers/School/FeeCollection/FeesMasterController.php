<?php

namespace App\Http\Controllers\School\FeeCollection;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Common\ClassListResource;
use App\Http\Resources\School\Fees_Collection\AddFeesResource;
use App\Http\Resources\School\Fees_Collection\FeeAdmissionResource;
use App\Http\Resources\School\Fees_Collection\FeePaymentResource;
use App\Http\Resources\School\Fees_Collection\FeesGroupDropDownResource;
use App\Http\Resources\School\Fees_Collection\FeesMasterResource;
use App\Http\Resources\School\Fees_Collection\FeesTypeDropDownResource;
use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Http\Resources\School\Student\StudentGuardianResource;
use App\Models\Admission;
use App\Models\Fee;
use App\Models\FeeGroup;
use App\Models\FeeMaster;
use App\Models\FeeType;
use App\Models\SchoolClass;
use App\Models\SchoolSection;
use App\Models\StudentGuardian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FeesMasterController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $feesmasters= FeeMaster::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($feesmasters) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'fees_masters' =>FeesMasterResource::collection($feesmasters),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'fees_masters' => null,
            'message' => 'No Fees Master add yet..',
        ]);
    }
    public function getClassFeesTypeData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $class= SchoolClass::where('school_id',$activeSchool->id)->allowed()->get();
        $feesTypes= FeeType::where('school_id',$activeSchool->id)->allowed()->get();
        return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'class_list' => $class && count($class) > 0 ? ClassListResource::collection($class) : null,
            'fees_type_list' => FeesTypeDropDownResource::collection($feesTypes),
        ]);
    }
    public function getFeesGroupData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $feesGroups= FeeGroup::where('school_id',$activeSchool->id)->where('school_class_id' , $request->class_id)->allowed()->get();


        if($feesGroups && count($feesGroups) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'fees_group_list' => $feesGroups && count($feesGroups) > 0 ? FeesGroupDropDownResource::collection($feesGroups) : null,

        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'fees_type_list' => null,
        ]);
    }
    public function getAdmissionData(Request $request ){

        if ($request->has('class') && $request->class != '-1') {
            if ($request->has('section') && $request->section != '-1') {
                $admissions = Admission::where('school_class_id', $request->class)->where('school_section_id', $request->section)->get();
            } else {
                $admissions = Admission::where('school_class_id', $request->class)->get();
            }
        }else{
            $admissions = Admission::get();
        }

        if($admissions) return response([
            'status' => 'success',
            'status_code' => 200,
            'student_admissions' => StudentAdmissionResource::collection($admissions),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_admissions' => null,
            'message' => 'No admission selected yet'
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
        $feesmaster = FeeMaster::where('class_id',$request->fees_master_class)->where('fee_group_id', $request->fees_master_fees_group)->where('school_id', $activeSchool->id)->allowed()->first();
        if($feesmaster) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Fees Master already exits'
        ]);

        $created = FeeMaster::create([
            'school_id'=> $activeSchool->id,
            'class_id'=>$request->fees_master_class,
            'fee_group_id' =>  $request->fees_master_fees_group,
            'fee_types_id' => $request->fees_master_fees_type,
            'due_date' => $request->fees_master_due_date,
            'amount' =>  $request->fees_master_amount,
            'fine_type' => $request->fees_master_fine_type,
            'fine_amount' => $request->fees_master_fine_amount,
            // 'percentage' => $request->fees_master_percentage,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Fees Master Created Successfully',
                'fees_master' => new FeesMasterResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create fees master',
        ]);
    }

    public function getEditData(FeeMaster $feesMaster)
    {
        return response([
            'status' => 'success',
            'fees_master' => new FeesMasterResource($feesMaster),
        ]);
    }

    public function updateData(Request $request , FeeMaster $feesMaster)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = FeeMaster::where('class_id',$request->fees_master_class)->where('fee_group_id', $request->fees_master_fees_group)->where('school_id', $activeSchool->id)->where('id','!=',$feesMaster->id)->allowed()->first();
        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Fees Master already exits'
        ]);
        $update = $feesMaster->update([
            'class_id'=>$request->fees_master_class,
            'fee_group_id' =>  $request->fees_master_fees_group,
            'fee_types_id' => $request->fees_master_fees_type,
            'due_date' => $request->fees_master_due_date,
            'amount' =>  $request->fees_master_amount,
            'fine_type' => $request->fees_master_fine_type,
            'fine_amount' => $request->fees_master_fine_amount,
            // 'percentage' => $request->fees_master_percentage,
        ]);

        if($update){
            $updateFeeMaster = FeeMaster::find($feesMaster->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Fees Master Updated Successfully',
                'fees_master' => new FeesMasterResource($updateFeeMaster),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Fees Master',
        ]);
    }

    public function changeStatusData(Request $request, FeeMaster $feesMaster)
    {
        $update = $feesMaster->update(['status' => $request->fees_master_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Fees Master data successfully ' . $request->fees_master_status,
        ]);
        if ($request->fees_master_status == 'activated') $message =
            'activate';
        else if ($request->fees_master_status == 'deactivated') $message =
            'dectivate';
        else if ($request->fees_master_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }

    public function getAdmissionDetailData(Admission $admission)
    {
        $fees_masters = FeeMaster::where('class_id' , $admission->school_class_id)->allowed()->get();
        Session::put('student_id', $admission->id);
        if(count($fees_masters) > 0) return response([
            'status' => 'success' ,
            'student_admission' => new StudentAdmissionResource($admission),
            'student_fees' =>  FeesMasterResource::collection($fees_masters),
            'message' => '',
        ]);
    }

    public function getFeesPaymentData(Admission $admission , FeeMaster $feeMaster)
    {
        $fees = Fee::where('admission_id' , $admission->id)->where('fees_master_id', $feeMaster->id)->allowed()->get();
        Session::put('student_id', $admission->id);
        return response([
            'status' => 'success' ,
            'student_admissions' => new StudentAdmissionResource($admission),
            'student_fees' => new FeesMasterResource($feeMaster),
            'message' => '',
            'fees' => FeePaymentResource::collection($fees),
        ]);
    }
}
