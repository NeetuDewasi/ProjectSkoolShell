<?php

namespace App\Http\Controllers\School\Hostel;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Hostel\HostelListResource;
use App\Http\Resources\School\Hostel\RoomTypeResource;
use App\Models\Hostel;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoomTypeController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $room_types= RoomType::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($room_types) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'room_types' =>RoomTypeResource::collection($room_types),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'room_types' => null,
            'message' => 'No Room Types add yet..',
        ]);
    }
    public function getHostelData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $hostels= Hostel::where('school_id',$activeSchool->id)->allowed()->get();

        if($hostels && count($hostels) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'hostel_list' => HostelListResource::collection($hostels),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'hostels' => null,
            'message' => 'No Hostel added yet..',
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
        $room_type = RoomType::where('room_type', $request->room_type_name)->where('hostel_id',$request->room_hostel)->where('school_id', $activeSchool->id)->allowed()->first();
        if($room_type) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Room Types already exits'
        ]);
        $created = RoomType::create([
            'school_id'=> $activeSchool->id,
            'hostel_id'=> $request->room_hostel_id,
            'room_type' =>  $request->room_type_name,
            'description' => $request->room_type_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Room Type Created Successfully',
                'room_type' => new RoomTypeResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Room Type',
        ]);
    }

    public function getEditData(RoomType $room_type)
    {
        return response([
            'status' => 'success',
            'room_type' => new RoomTypeResource($room_type),
        ]);
    }

    public function updateData(Request $request , RoomType $room_type)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        // $alreadyExit = RoomType:: where('school_id', $activeSchool->id)->where('id','!=',$room_type->id)->allowed()->first();
        // if($alreadyExit) return response([
        //     'status' => 'warning',
        //     'status_code' => 300,
        //     'message' => 'This Room Types already exits'
        // ]);
        $update = $room_type->update([
            'hostel_id'=> $request->room_hostel_id,
            'room_type' =>  $request->room_type_name,
            'description' => $request->room_type_description,
        ]);

        if($update){
            $updateRoomType = RoomType::find($room_type->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Room Type Updated Successfully',
                'room_type' => new RoomTypeResource($updateRoomType),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Room Type',
        ]);
    }

    public function changeStatusData(Request $request, RoomType $room_type)
    {
        $update = $room_type->update(['status' => $request->room_type_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Room Type data successfully ' . $request->room_type_status,
        ]);

        if ($request->room_type_status == 'activated') $message =
            'activate';
        else if ($request->room_type_status == 'deactivated') $message =
            'dectivate';
        else if ($request->room_type_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
