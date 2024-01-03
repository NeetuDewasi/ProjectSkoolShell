<?php

namespace App\Http\Controllers\Admin\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\School\SchoolResource;
use Illuminate\Http\Request;
use App\Models\SchoolGroup;
use App\Http\Resources\Admin\SchoolGroup\SchoolGroupResource;
use App\Models\School;

class SchoolGroupController extends Controller
{
    public function getData(){
        $groups = SchoolGroup::active()->get();
        if(count($groups)>0)
            return response([
                'status_code'=>200,
                'status'=>'success',
                'groups'=> SchoolGroupResource::collection($groups)
            ]);
         return response([
            'status' => 'warning',
            'status_code' => 300,
            'groups' => null,
            'message' => 'No group created yet'
        ]);
    }
    public function savedata(Request $request){
        $school_group = SchoolGroup::where('name', $request->group_name)->first();
        if ($school_group) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Group is already exist'
        ]);
        $create = SchoolGroup::create([
            'name' => $request->group_name,
            'contact_person_name' => $request->contact_person,
            'mobile' => $request->mobile_number,
            'alternative_mobile' => $request->mobile_number,
            'email' => $request->email_id,
            'alternative_email' => $request->alternative_email_id,
        ]);
        if($create) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'school group created successfully',
                'group' => new SchoolGroupResource($create),
        ]);
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create group',
        ]);
    }
    }
    public function getEditItem(SchoolGroup $school_group){
        $group = SchoolGroup ::where('id',$school_group->id)->allowed()->first();
        if($group){
            return response([
                'status_code'=>200,
                'status'=>'success',
                'group'=> new SchoolGroupResource($group)
            ]);
        }
    }
    public function getDataItem($id)
    {
        dd($id);
        $school = School::where('id', $id)->first();
        if ($school) return response([
            'status' => 'success',
            'school' => new SchoolResource($school),
        ]);
        return response([
            'status' => 'warning',
            'school' => null,
            'message' => 'No DailyTip created yet'
        ]);
    }
    public function updateGroup(SchoolGroup $school_group, Request $request){
        $update = $school_group->update([
            'name' => $request->group_name,
            'contact_person_name' => $request->contact_person,
            'mobile' => $request->mobile_number,
            'alternative_mobile' => $request->mobile_number,
            'email' => $request->email_id,
            'alternative_email' => $request->alternative_email_id,
        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'school group updated successfully',
        ]);
    }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update group',
        ]);
    }
    public function changeStatusData(Request $request, SchoolGroup $schoolGroup)
    {
        $updated = $schoolGroup->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'School Group successfully ' . $request->status,
        ]);

        if ($request->status == 'activated') $message =
            'activate';
        else if ($request->status == 'deactivated') $message =
            'dectivate';
        else if ($request->status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
