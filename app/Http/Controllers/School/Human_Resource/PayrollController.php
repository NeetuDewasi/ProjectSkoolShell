<?php

namespace App\Http\Controllers\School\Human_Resource;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Human_Resource\PayRollResource;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PayrollController extends Controller
{public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $payrolls= Payroll::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($payrolls) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'payrolls' =>PayRollResource::collection($payrolls),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'payrolls' => null,
            'message' => 'No Payrolls add yet..',
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
        $payroll = Payroll::where('epf_no', $request->payroll_epf_no)->where('id',)->where('school_id', $activeSchool->id)->first();
        if($payroll) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This payroll already exits'
        ]);

        $created = Payroll::create([
            'school_id'=> $activeSchool->id,
            'employee_id' =>  $request->payroll_employee,
            'epf_no' =>  $request->payroll_epf_no,
            'basic_salary' =>  $request->payroll_basic_salary,
            'contract_type' =>  $request->payroll_contract_type,
            'working_shift' =>  $request->payroll_working_shift,
            'location' =>  $request->payroll_location,

        ]);
        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Employee Payroll Created Successfully',
                'payroll' => new PayRollResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Employee Payroll',
        ]);
    }

    public function getEditData(Payroll $payroll)
    {
        return response([
            'status' => 'success',
            'payroll' => new PayRollResource($payroll),
        ]);
    }

    public function updateData(Request $request , Payroll $payroll)
    {
        $update = $payroll->update([
            'employee_id' =>  $request->payroll_employee,
            'epf_no' =>  $request->payroll_epf_no,
            'basic_salary' =>  $request->payroll_basic_salary,
            'contract_type' =>  $request->payroll_contract_type,
            'working_shift' =>  $request->payroll_working_shift,
            'location' =>  $request->payroll_location,
        ]);

        if($update){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Employee Payroll Updated Successfully',
                'payroll' => new PayRollResource($payroll),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Employee Payroll',
        ]);
    }

    public function changeStatusData(Request $request, Payroll $payroll)
    {
        $update = $payroll->update(['status' => $request->payroll_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Enquiries data successfully ' . $request->payroll_status,
        ]);

        if ($request->payroll_status == 'activated') $message =
            'activate';
        else if ($request->payroll_status == 'deactivated') $message =
            'dectivate';
        else if ($request->payroll_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
