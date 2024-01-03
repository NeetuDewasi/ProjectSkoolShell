<?php

namespace App\Http\Controllers\Admin\Backend\Assign;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\School;
use App\Models\AssignModule;
use App\Http\Resources\Admin\RoleListResource;
use App\Http\Resources\Admin\School\SchoolListResource;
use App\Http\Resources\Admin\Assign\AssignResource;
use App\Http\Resources\Admin\Assign\AssignedMenuResource;
class AssignController extends Controller
{

    public function getSchools(Request $request){
        $schools = School::where('school_group_id',$request->group_id)->get();
        if(count($schools) > 0) return response([
            'status_code' => 200,
            'status' => 'success',
            'schools' => SchoolListResource::collection($schools),
        ]);
        return response([
            'status_code' => 300,
            'status' => 'warning',
            'message' => 'No school created yet',
        ]);
    }
    public function getData1(){
        $menuList = AssignModule::allowed()->get();
         if(count($menuList) > 0) return response([
            'status_code' => 200,
            'status' => 'success',
            'menuList'=>AssignedMenuResource::collection($menuList),
        ]);
        return response([
            'status_code' => 300,
            'status' => 'warning',
            'message' => 'No menu assigned yet',
        ]);
    }
    public function saveData(Request $request){
        $menu = AssignModule::where('school_id',$request->school_id)->first();
            $create = AssignModule::create([
               'school_group_id'=>$request->group_id,
               'school_id'=>$request->school_id,
               'name' => json_encode($request->selectedModules),
               ]);

        if($create) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Modules Created Successfully',
                'assigned_module' => new AssignResource($create),
        ]);
       }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Module',
        ]);
    }
    public function updateData(Request $request, AssignModule $assignModule){

        $menu = AssignModule::where('school_id',$request->school_id)->first();
            $update = $assignModule->update([
                'school_group_id' => $request->group_id,
               'school_id'=>$request->school_id,
               'name' => json_encode($request->selectedModules),
               ]);

        if($update)
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Modules Updated Successfully',
                'assigned_module' => $update,
        ]);
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Module',
        ]);

    }
     public function changeStatusData(Request $request, AssignModule $assignModule)
    {
        $updated = $assignModule->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Menus data successfully ' . $request->status,
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
