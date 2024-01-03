<?php

namespace App\Http\Controllers\School\FeeCollection;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Fees_Collection\FeesGroupResource;
use App\Models\FeeGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FeesGroupController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $feesgroups = FeeGroup::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($feesgroups) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'fees_groups' =>FeesGroupResource::collection($feesgroups),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'fees_groups' => null,
            'message' => 'No Fees Group Created Yet',
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
        $feesgroup = FeeGroup::where('name', $request->fees_group_name)->where('school_id', $activeSchool->id)->allowed()->first();

        if($feesgroup) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Fees Group already exits'
        ]);

        $created = FeeGroup::create([
            'school_id'=> $activeSchool->id,
            'school_class_id'=> $request->fees_class_id,
            'name' =>  $request->fees_group_name,
            'description' => $request->fees_group_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Fees Group Created Successfully',
                'fees_group' => new FeesGroupResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create fees group',
        ]);
    }
    public function getEditData(FeeGroup $feesGroup)
    {
        return response([
            'status' => 'success',
            'fees_group' => new FeesGroupResource($feesGroup),
        ]);
    }

    public function updateData(Request $request , FeeGroup $feesGroup)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = FeeGroup::where('name', $request->fees_group_name)->where('school_id', $activeSchool->id)->where('id', '!=' , $feesGroup->id)->allowed()->first();

        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Fees Group already exits'
        ]);
        $update = $feesGroup->update([
            'school_class_id'=> $request->fees_class_id,
            'name' =>  $request->fees_group_name,
            'description' => $request->fees_group_description,

        ]);

        if($update){
            $updateFeesGroup = FeeGroup::find($feesGroup->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Fees Group Updated Successfully',
                'fees_group' => new FeesGroupResource($updateFeesGroup),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Fees Groups',
        ]);
    }

    public function changeStatusData(Request $request, FeeGroup $feesGroup)
    {
        $update = $feesGroup->update(['status' => $request->fees_group_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Fees Group data successfully ' . $request->fees_group_status,
        ]);

        if ($request->fees_group_status == 'activated') $message =
            'activate';
        else if ($request->fees_group_status == 'deactivated') $message =
            'dectivate';
        else if ($request->fees_group_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }

}
