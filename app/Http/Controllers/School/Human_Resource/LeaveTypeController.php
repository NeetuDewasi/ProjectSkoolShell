<?php

namespace App\Http\Controllers\School\Human_Resource;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Human_Resource\EmployeeLeaveTypeResource;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LeaveTypeController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $leaveTypes = LeaveType::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($leaveTypes) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'leave_types' => EmployeeLeaveTypeResource::collection($leaveTypes),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'leave_types' => null,
            'message' => 'No leave type add yet..',
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
        $leaveType = LeaveType::where('school_id', $activeSchool->id)->where('title', $request->leave_type_title)->allowed()->first();

        if($leaveType) return response([
            'status' => 'warning',
            'status_code' => 300,
            'leave_types' => null,
            'message' => 'Group title already exists',
        ]);

        $created = LeaveType::create([
            'school_id' => $activeSchool->id,
            'title' => $request->leave_type_title,
        ]);

        if($created) return response([
            'status' => 'success',
            'status_code' => 201,
            'leave_type' => new EmployeeLeaveTypeResource($created),
            'message' => 'Leave type created successfully',
        ]);
        return response([
            'status' => 'error',
            'status_code' => 400,
            'leave_type' => null,
            'message' => 'Oops!! something went wrong. Unable to create type',
        ]);
    }

    public function updateData(Request $request, LeaveType $leaveType)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $leaveType = LeaveType::where('school_id', $activeSchool->id)->where('id', '!=', $leaveType->id)->where('title', $request->leave_type_title)->allowed()->first();
        if($leaveType) return response([
            'status' => 'warning',
            'status_code' => 300,
            'leave_types' => null,
            'message' => 'Leave type title already exists',
        ]);
        $updated = $leaveType->update([
            'department_id' => $request->department_id,
            'title' => $request->leave_type_title,
        ]);
        if($updated) {
            $leaveType = LeaveType::find($leaveType->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'leave_type' => new EmployeeLeaveTypeResource($leaveType),
                'message' => 'Leave type updated successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'leave_type' => null,
            'message' => 'Oops!! something went wrong. Unable to update type',
        ]);
    }

    public function deleteData(Request $request, LeaveType $leaveType)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $deleted = $leaveType->update(['status' => 'deleted']);
        if($deleted) return response([
            'status' => 'success',
            'status_code' => 201,
            'message' => 'Leave type deleted successfully',
        ]);
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! something went wrong. Unable to delete leave type',
        ]);
    }
}
