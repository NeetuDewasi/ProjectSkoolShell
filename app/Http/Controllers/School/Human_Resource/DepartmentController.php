<?php

namespace App\Http\Controllers\School\Human_Resource;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Human_Resource\DepartmentResource;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $departments= Department::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($departments) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'departments' =>DepartmentResource::collection($departments),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'departments' => null,
            'message' => 'No Departments add yet..',
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
        $department = Department::where('name', $request->department_name)->where('school_id', $activeSchool->id)->first();
        if($department) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Department already exits'
        ]);

        $created = Department::create([
            'school_id'=> $activeSchool->id,
            'name' =>  $request->department_name,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Department Created Successfully',
                'department' => new DepartmentResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Department',
        ]);
    }

    public function updateData(Request $request , Department $department)
    {
        $update = $department->update([
            'name' => $request->department_name,
        ]);


        if($update){

            $updatedDepartment = Department::find($department->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Departments Updated Successfully',
                'department' => new DepartmentResource($updatedDepartment),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Department',
        ]);
    }

    public function changeStatusData(Request $request, Department $department)
    {
        $update = $department->update(['status' => $request->department_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Department data successfully ' . $request->department_status,
        ]);

        if ($request->department_status == 'activated') $message =
            'activate';
        else if ($request->department_status == 'deactivated') $message =
            'dectivate';
        else if ($request->department_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
