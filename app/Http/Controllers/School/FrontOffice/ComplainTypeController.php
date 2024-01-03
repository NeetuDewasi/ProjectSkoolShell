<?php

namespace App\Http\Controllers\School\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Front_Office\ComplainTypeResource;
use App\Models\Complain;
use App\Models\ComplainType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ComplainTypeController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $complain_types = ComplainType::where('school_id',$activeSchool->id)->allowed()->get(); // isme value nhi h
        if(count($complain_types) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'complain_types' =>ComplainTypeResource::collection($complain_types),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'complain_types' => null,
            'message' => 'No Complain Types Created Yet',
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
        $complain_type = ComplainType::where('title', $request->complain_type_name)->where('school_id', $activeSchool->id)->allowed()->first();

        if($complain_type) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Complain Type already exits'
        ]);

        $created = ComplainType::create([
            'school_id'=> $activeSchool->id,
            'title' =>  $request->complain_type_name,
            'description' => $request->complain_type_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Complain Type Created Successfully',
                'complain_type' => new ComplainTypeResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Complain',
        ]);
    }
    public function getEditData(ComplainType $complain_type)
    {
        return response([
            'status' => 'success',
            'complain_type' => new ComplainTypeResource($complain_type),
        ]);
    }

    public function updateData(Request $request, ComplainType $complain_type)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = ComplainType::where('title', $request->complain_type_name)->where('school_id', $activeSchool->id)->where('id', '!=', $complain_type->id)->allowed()->first();

        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Complain Type already exits'
        ]);
        $update = $complain_type->update([
            'title' =>  $request->complain_type_name,
            'description' => $request->complain_type_description,

        ]);
        if($update){
            $updateComplainType = ComplainType::find($complain_type->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Complain Type Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Complain Type',
        ]);
    }

    public function changeStatusData(Request $request, ComplainType $complain_type)
    {
        $update = $complain_type->update(['status' => $request->complain_type_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Complain Type data successfully ' . $request->complain_type_status,
        ]);

        if ($request->complain_type_status == 'activated') $message =
            'activate';
        else if ($request->complain_type_status == 'deactivated') $message =
            'dectivate';
        else if ($request->complain_type_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
