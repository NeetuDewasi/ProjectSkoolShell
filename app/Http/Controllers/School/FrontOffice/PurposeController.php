<?php

namespace App\Http\Controllers\School\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Front_Office\PurposeResource;
use App\Models\Purpose;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PurposeController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $purposes = Purpose::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($purposes) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'purposes' =>PurposeResource::collection($purposes),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'purposes' => null,
            'message' => 'No Purpose Created Yet',
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
        $purpose = Purpose::where('title', $request->purpose_name)->where('school_id', $activeSchool->id)->allowed()->first();

        if($purpose) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Purpose already exits'
        ]);

        $created = Purpose::create([
            'school_id'=> $activeSchool->id,
            'title' =>  $request->purpose_name,
            'description' => $request->purpose_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Purpose Created Successfully',
                'purpose' => new PurposeResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Purpose',
        ]);
    }
    public function getEditData(Purpose $purpose)
    {
        return response([
            'status' => 'success',
            'purpose' => new PurposeResource($purpose),
        ]);
    }

    public function updateData(Request $request , Purpose $purpose)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = Purpose::where('title', $request->purpose_name)->where('school_id', $activeSchool->id)->allowed()->first();

        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Purpose already exits'
        ]);
        $update = $purpose->update([
            'title' =>  $request->purpose_name,
            'description' => $request->purpose_description,

        ]);
        if($update){
            $updatePurpose = Purpose::find($purpose->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Purpose Updated Successfully',
                'purpose' => new PurposeResource($updatePurpose),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Purpose',
        ]);
    }

    public function changeStatusData(Request $request, Purpose $purpose)
    {
        $update = $purpose->update(['status' => $request->purpose_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Purpose data successfully ' . $request->purpose_status,
        ]);

        if ($request->purpose_status == 'activated') $message =
            'activate';
        else if ($request->purpose_status == 'deactivated') $message =
            'dectivate';
        else if ($request->purpose_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
