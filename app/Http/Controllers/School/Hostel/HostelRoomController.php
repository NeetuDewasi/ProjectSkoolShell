<?php

namespace App\Http\Controllers\School\Hostel;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Hostel\HostelListResource;
use App\Http\Resources\School\Hostel\HostelRoomResource;
use App\Http\Resources\School\Hostel\RoomTypeListResource;
use App\Models\Hostel;
use App\Models\HostelRoom;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HostelRoomController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $hostel_rooms= HostelRoom::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($hostel_rooms) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'hostel_rooms' =>HostelRoomResource::collection($hostel_rooms),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'hostel_rooms' => null,
            'message' => 'No Hostel Room add yet..',
        ]);
    }
    public function getHostelRoomTypeData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $hostel= Hostel::where('school_id',$activeSchool->id)->allowed()->get();
        $room_type= RoomType::where('school_id',$activeSchool->id)->allowed()->get();

        return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'hostel_list' => $hostel && count($hostel) > 0 ? HostelListResource::collection($hostel) : null,
            'room_type_list' => $room_type && count($room_type) > 0 ? RoomTypeListResource::collection($room_type) : null,

        ]);
    }
    public function getHostelRoomTypes(Hostel $hostel)
    {
        $hostelRoomTypes = RoomType::where('hostel_id', $hostel->id)->allowed()->get();
        if ($hostelRoomTypes && count($hostelRoomTypes) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'hostel_room_types' => RoomTypeListResource::collection($hostelRoomTypes),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'hostel_room_types' => null,
            'message' => 'No section selected yet'
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
        $hostel_room = HostelRoom::where('room_name', $request->hostel_room_name)->where('hostel_id', $request->hostel_room_hostel)->where('school_id', $activeSchool->id)->allowed()->first();
        if($hostel_room) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Hostel Room already exits'
        ]);
        $created = HostelRoom::create([
            'school_id'=> $activeSchool->id,
            'hostel_id'=> $request->hostel_room_hostel,
            'room_type_id'=> $request->hostel_room_type,
            'room_name' =>  $request->hostel_room_name,
            'number_of_bed' =>  $request->hostel_room_no_of_bed,
            'cost_per_bed' =>  $request->hostel_room_cost,
            'description' => $request->hostel_room_description,
        ]);

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Hostel Room Created Successfully',
                'hostel_room' => new HostelRoomResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Hostel Room',
        ]);
    }

    public function getEditData(HostelRoom $hostel_room)
    {
        return response([
            'status' => 'success',
            'hostel_room' => new HostelRoomResource($hostel_room),
        ]);
    }

    public function updateData(Request $request , HostelRoom $hostel_room)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExit = HostelRoom::where('room_name', $request->hostel_room_name)->where('hostel_id', $request->hostel_room_hostel)->where('school_id', $activeSchool->id)->where('id', '!=', $hostel_room->id)->allowed()->first();
        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Hostel Room already exits'
        ]);
        $update = $hostel_room->update([
            'hostel_id'=> $request->hostel_room_hostel,
            'room_type_id'=> $request->hostel_room_type,
            'room_name' =>  $request->hostel_room_name,
            'number_of_bed' =>  $request->hostel_room_no_of_bed,
            'cost_per_bed' =>  $request->hostel_room_cost,
            'description' => $request->hostel_room_description,
        ]);

        if($update){
            $updateHostelRoom = HostelRoom::find($hostel_room->id);
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Hostel Room Updated Successfully',
                'hostel_room' => new HostelRoomResource($updateHostelRoom),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Hostel Room',
        ]);
    }

    public function changeStatusData(Request $request, HostelRoom $hostel_room)
    {
        $update = $hostel_room->update(['status' => $request->hostel_room_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Room Type data successfully ' . $request->hostel_room_status,
        ]);

        if ($request->hostel_room_status == 'activated') $message =
            'activate';
        else if ($request->hostel_room_status == 'deactivated') $message =
            'dectivate';
        else if ($request->hostel_room_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
