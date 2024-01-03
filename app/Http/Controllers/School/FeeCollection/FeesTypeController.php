<?php

namespace App\Http\Controllers\School\FeeCollection;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Fees_Collection\FeesTypeResource;
use App\Models\FeeType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FeesTypeController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $feestypes = FeeType ::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($feestypes) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'fees_types' =>FeesTypeResource::collection($feestypes),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'fees_types' => null,
            'message' => 'No Fees Type Created Yet',
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
        $feestype = FeeType::where('name', $request->fees_type_name)->where('school_id', $activeSchool->id)->allowed()->first();

        if($feestype) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Fees type already exits'
        ]);

        $created = FeeType::create([
            'school_id'=> $activeSchool->id,
            'name' =>  $request->fees_type_name,
            'fees_code' =>  $request->fees_type_fees_code,
            'description' => $request->fees_type_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Fees type Created Successfully',
                'fees_type' => new FeesTypeResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create fees type',
        ]);
    }
    public function getEditData(FeeType $feesType)
    {
        return response([
            'status' => 'success',
            'fees_type' => new FeesTypeResource($feesType),
        ]);
    }

    public function updateData(Request $request , FeeType $feesType)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = FeeType::where('name', $request->fees_type_name)->where('school_id', $activeSchool->id)->where('id', '!=', $feesType->id)->allowed()->first();

        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Fees type already exits'
        ]);
        $update = $feesType->update([
            'name' =>  $request->fees_type_name,
            'fees_code' =>  $request->fees_type_fees_code,
            'description' => $request->fees_type_description,

        ]);

        if($update){
            $updateFeesType = FeeType::find($feesType->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Fees Type Updated Successfully',
                'fees_type' => new FeesTypeResource($updateFeesType),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Fees Type',
        ]);
    }

    public function changeStatusData(Request $request, FeeType $feesType)
    {
        $update = $feesType->update(['status' => $request->fees_type_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Fees Type data successfully ' . $request->fees_type_status,
        ]);

        if ($request->fees_type_status == 'activated') $message ='activate';
        else if ($request->fees_type_status == 'deactivated') $message ='dectivate';
        else if ($request->fees_type_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
