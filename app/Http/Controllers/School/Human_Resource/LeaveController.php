<?php

namespace App\Http\Controllers\School\Human_Resource;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Human_Resource\EmployeeLeaveResource;
use App\Http\Resources\School\Human_Resource\LeaveTypeDropdownsResource;
use App\Models\EmployeeLeave;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LeaveController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $employeeLeaveRequests = EmployeeLeave::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($employeeLeaveRequests) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'employee_leave_request' => EmployeeLeaveResource::collection($employeeLeaveRequests),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'employee_leave_request' => null,
            'message' => 'No leave add yet..',
        ]);
    }
    // Apply Leave (Leave Request Form)
    public function getLeaveTypes()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $LeaveTypes = LeaveType::where('school_id', $activeSchool->id)->allowed()->get();
        if (count($LeaveTypes) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'leave_type_list' => LeaveTypeDropdownsResource::collection($LeaveTypes),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'leave_type_list' => null,
            'message' => 'No leave added yet..',
        ]);
    }
    public function saveData(Request $request)
    {
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        foreach ($request->subjects as $key => $value) {
            $created = AddExamSubject::create([
                'school_id' => $activeSchool->id,
                'examgroup_id' => $request->examgroup_id,
                'exam_id' => $request->exam_id,

            ]);
        }
}
}
