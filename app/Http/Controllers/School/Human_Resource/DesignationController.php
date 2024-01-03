<?php

namespace App\Http\Controllers\School\Human_Resource;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Human_Resource\DesignationResource;
use App\Models\Designation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DesignationController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $designations= Designation::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($designations) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'designations' =>DesignationResource::collection($designations),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'designations' => null,
            'message' => 'No Designations add yet..',
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
        $designation = Designation::where('name', $request->designation_name)->where('school_id', $activeSchool->id)->first();
        if($designation) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Designation already exits'
        ]);

        $created = designation::create([
            'school_id'=> $activeSchool->id,
            'name' =>  $request->designation_name,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'designation Created Successfully',
                'designation' => new DesignationResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Designation',
        ]);
    }

    public function updateData(Request $request , Designation $designation)
    {
        $update = $designation->update([
            'name' => $request->designation_name,
        ]);


        if($update){

            $updateddesignation = Designation::find($designation->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Enquiries Updated Successfully',
                'designation' => new DesignationResource($updateddesignation),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Designation',
        ]);
    }

    public function changeStatusData(Request $request, Designation $designation)
    {
        $update = $designation->update(['status' => $request->designation_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'designation data successfully ' . $request->designation_status,
        ]);

        if ($request->designation_status == 'activated') $message =
            'activate';
        else if ($request->designation_status == 'deactivated') $message =
            'dectivate';
        else if ($request->designation_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
