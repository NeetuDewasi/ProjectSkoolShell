<?php

namespace App\Http\Controllers\School\Human_Resource;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Human_Resource\EmployeeLeaveGroupResource;
use App\Http\Resources\School\Human_Resource\EmployeeLeaveGroupRuleResource;
use App\Http\Resources\School\Human_Resource\EmployeeLeaveTypeResource;
use App\Models\LeaveGroup;
use App\Models\LeaveGroupRule;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LeaveGroupController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $leaveGroups = LeaveGroup::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($leaveGroups) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'leave_groups' => EmployeeLeaveGroupResource::collection($leaveGroups),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'leave_groups' => null,
            'message' => 'No leave group add yet..',
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
        $leaveGroup = LeaveGroup::where('school_id', $activeSchool->id)->where('department_id', $request->department_id)->where('title', $request->leave_group_title)->allowed()->first();

        if($leaveGroup) return response([
            'status' => 'warning',
            'status_code' => 300,
            'leave_groups' => null,
            'message' => 'Group title already exists',
        ]);

        $created = LeaveGroup::create([
            'school_id' => $activeSchool->id,
            'department_id' => $request->department_id,
            'title' => $request->leave_group_title,
        ]);

        if($created) return response([
            'status' => 'success',
            'status_code' => 201,
            'leave_group' => new EmployeeLeaveGroupResource($created),
            'message' => 'Leave group created successfully',
        ]);
        return response([
            'status' => 'error',
            'status_code' => 400,
            'leave_group' => null,
            'message' => 'Oops!! something went wrong. Unable to create group',
        ]);
    }
    public function updateData(Request $request, LeaveGroup $leaveGroup)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $leaveGroup = LeaveGroup::where('school_id', $activeSchool->id)->where('id', '!=', $leaveGroup->id)->where('department_id', $request->department_id)->where('title', $request->leave_group_title)->allowed()->first();

        if($leaveGroup) return response([
            'status' => 'warning',
            'status_code' => 300,
            'leave_groups' => null,
            'message' => 'Group title already exists',
        ]);

        $updated = $leaveGroup->update([
            'department_id' => $request->department_id,
            'title' => $request->leave_group_title,
        ]);

        if($updated) {
            $leaveGroup = LeaveGroup::find($leaveGroup->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'leave_group' => new EmployeeLeaveGroupResource($leaveGroup),
                'message' => 'Leave group updated successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'leave_group' => null,
            'message' => 'Oops!! something went wrong. Unable to update group',
        ]);
    }

    public function deleteData(Request $request, LeaveGroup $leaveGroup)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $deleted = $leaveGroup->update(['status' => 'deleted']);

        if($deleted) return response([
            'status' => 'success',
            'status_code' => 201,
            'message' => 'Leave group deleted successfully',
        ]);

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! something went wrong. Unable to delete leave group',
        ]);
    }


    public function getRuleData(LeaveGroup $leaveGroup)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $leaveTypes = LeaveType::where('school_id', $activeSchool->id)->allowed()->get();
        $leaveGroupRules = LeaveGroupRule::where('school_id', $activeSchool->id)->where('leave_group_id', $leaveGroup->id)->get();

        return response([
            'status' => 'success',
            'status_code' => 200,
            'leave_types' => EmployeeLeaveTypeResource::collection($leaveTypes),
            'leave_group_rules' => EmployeeLeaveGroupRuleResource::collection($leaveGroupRules),
            'leave_group' => new EmployeeLeaveGroupResource($leaveGroup),
            'message' => '',
        ]);
    }

    public function saveRuleData(Request $request, LeaveGroup $leaveGroup)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }

        $leaveCounts = json_decode($request->leave_rule_data);


        $leaveTypes = LeaveType::where('school_id',$activeSchool->id)->allowed()->get();
        foreach ($leaveTypes as $key => $leaveType) {
            $leaveGroupRule = LeaveGroupRule::where('school_id',$activeSchool->id)->where('leave_type_id', $leaveType->id)->where('leave_group_id', $leaveGroup->id)->first();
            if($leaveGroupRule) {
               $leaveGroupRule->update([
                'leave' => $leaveCounts->leave_type_counts[$key]
               ]);
            } else {
                LeaveGroupRule::create([
                    'school_id' => $activeSchool->id,
                    'department_id' => $leaveGroup->department_id,
                    'leave_group_id' => $leaveGroup->id,
                    'leave_type_id' => $leaveType->id,
                    'rule_title' => $leaveType->title,
                    'leave' => $leaveCounts->leave_type_counts[$key]
                ]);
            }
        }

        $leaveGroupRules = LeaveGroupRule::where('school_id',$activeSchool->id)->where('leave_group_id', $leaveGroup->id)->get();

        return response([
            'status' => 'success',
            'status_code' => 200,
            'leave_types' => EmployeeLeaveTypeResource::collection($leaveTypes),
            'leave_group_rules' => EmployeeLeaveGroupRuleResource::collection($leaveGroupRules),
            'leave_group' => new EmployeeLeaveGroupResource($leaveGroup),
            'message' => 'Updated Successfully',
        ]);
    }
}
