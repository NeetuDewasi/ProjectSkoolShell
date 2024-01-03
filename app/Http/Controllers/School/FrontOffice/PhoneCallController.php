<?php

namespace App\Http\Controllers\School\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Front_Office\PhoneCallLogResource;
use App\Models\CallLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Prophecy\Call\Call;

class PhoneCallController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $calls= CallLog::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($calls) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'calls' =>PhoneCallLogResource::collection($calls),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'calls' => null,
            'message' => 'No Phone Calls add yet..',
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
        $call = CallLog::where('id',$request->phone_id)->where('school_id', $activeSchool->id)->allowed()->first();
        if($call) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Complains  already exits'
        ]);

        $created = CallLog::create([
            'school_id'=> $activeSchool->id,
            'name' =>  $request->phone_name,
            'phone' => $request->phone_phone,
            'date' => $request->phone_date,
            'next_date' => $request->phone_next_date,
            'call_duration_minute' => $request->phone_call_duration_minute,
            'call_duration_seconds' => $request->phone_call_duration_seconds,
            'call_type' =>$request->phone_call_type,
            'description' =>  $request->phone_description,
            'note' => $request->phone_note,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Phone Call Log Created Successfully',
                'call' => new PhoneCallLogResource($created),
                'request' => json_encode($request->all())
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Phone Call Log',
        ]);
    }

    public function getEditData(CallLog $call_log)
    {
        return response([
            'status' => 'success',
            'call' => new PhoneCallLogResource($call_log),
        ]);
    }

    public function updateData(Request $request , CallLog $call_log)
    {
        $update = $call_log->update([
            'name' =>  $request->phone_name,
            'phone' => $request->phone_phone,
            'date' => $request->phone_date,
            'next_date' => $request->phone_next_date,
            'call_duration_minute' => $request->phone_call_duration_minute,
            'call_duration_seconds' => $request->phone_call_duration_seconds,
            'call_type' =>$request->phone_call_type,
            'description' =>  $request->phone_description,
            'note' => $request->phone_note,
        ]);

        if($update){
            $updateCall = CallLog::find($call_log->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Phone Call Log Updated Successfully',
                'call' => new PhoneCallLogResource($updateCall),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Phone Call Log',
        ]);
    }

    public function changeStatusData(Request $request, CallLog $call_log)
    {
        $update = $call_log->update(['status' => $request->phone_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Phone Call Log data successfully ' . $request->phone_status,
        ]);

        if ($request->phone_status == 'activated') $message =
            'activate';
        else if ($request->phone_status == 'deactivated') $message =
            'dectivate';
        else if ($request->phone_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
    public function getCallData(CallLog $call_log)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $call_log = CallLog::where('id', $call_log->id)->where('school_id',$activeSchool->id)->allowed()->first();
        return response([
            'status' => 'success' ,
            'call' =>new PhoneCallLogResource($call_log),
            'message' => '',
        ]);
    }

}
