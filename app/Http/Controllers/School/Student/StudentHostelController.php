<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentHostel;
use App\Models\RoomType;
use App\Http\Resources\School\Student\HostelDropdownResource;
use App\Http\Resources\School\Student\StudentHostelResource;
use App\Http\Resources\School\Student\RoomTypeDropdownResource;
use App\Models\Hostel;
use App\Models\StudentHouse;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StudentHostelController extends Controller
{
    public function saveData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $created = StudentHostel::create([
            'school_id' => $activeSchool->id,
            'admission_id' => $request->admission_id,
            'hostel_id' => $request->hostel_id,
            'room_type_id' => $request->room_type_id,
            'is_hostal' => $request->isHostel,
            'bed_number' => $request->bed_number,
        ]);
        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Hostel created successfully',
                'student_hostel' => $created,
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Hostel',
        ]);
    }
    public function getHostelList()
    {
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $hostelList = Hostel::where('school_id', $activeSchool->id)->active()->get();

        if ($hostelList && count($hostelList) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'hostel_list' => HostelDropdownResource::collection($hostelList),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'hostel_list' => null,
            'message' => 'No Hostel added yet..',
        ]);
    }
    public function getRoomType(Hostel $hostel)
    {
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $hostelRoomTypeList = RoomType::where('school_id', $activeSchool->id)->where('hostel_id', $hostel->id)->get();

        if ($hostelRoomTypeList && count($hostelRoomTypeList) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'hostel_room_type_list' => RoomTypeDropdownResource::collection($hostelRoomTypeList),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'hostel_list' => null,
            'message' => 'No Hostel added yet..',
        ]);
    }
    public function getEditItemData(Request $request)
    {
        $studentHostel = StudentHostel::where('admission_id', $request->admission)->first();
        if ($studentHostel) return response([
            'status' => 'success',
            'status_code' => 200,
            'edit_hostel' => new StudentHostelResource($studentHostel),

            'message' => ''
        ]);

        return response([
            'status' => 'error',
            'edit_hostel' => null,
            'message' => ''
        ]);
    }
    public function updateData(Request $request, StudentHostel $studentHostel)
    {
        $updated = $studentHostel->update([
            'is_hostal' => $request->isHostel,
            'hostel_id' => $request->hostel_id,
            'room_type_id' => $request->room_type_id,
            'bed_number' => $request->bed_number,
        ]);
        if ($updated) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Hostel updated successfully',

            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Hostel',
        ]);
    }
}
