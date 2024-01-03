<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Student\StudentAddressResource;
use App\Http\Resources\School\Student\StudentGuardianResource;
use App\Models\StudentAddress;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentGuardian;
use Illuminate\Http\Request;

class StudentAddressController extends Controller
{
    public function getData()
    {
        $studentAddresses = StudentAddress::where('school_id', 1)->allowed()->get();
        if (count($studentAddresses) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'student_addresses' => StudentAddressResource::collection($studentAddresses),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_categories' => null,
            'message' => 'No address created yet'
        ]);
    }
    public function getStudentData($admission_id)
    {
        $studentGuardian = StudentGuardian::where('admission_id', $admission_id)->first();

        if ($studentGuardian) return response([
            'status' => 'success',
            'status_code' => 200,
            'student_guardian' => new StudentGuardianResource($studentGuardian),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_guardian' => null,
            'message' => 'No address created yet'
        ]);
    }

    public function saveData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $StudentAddress = StudentAddress::where('admission_id', $request->admission_id)->first();

        if ($StudentAddress) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Address is already exist'
        ]);

        $created = StudentAddress::create([
            'school_id' => $activeSchool->id,
            'admission_id' => $request->admission_id,
            'isCurrent' => $request->is_current_address,
            'isPermanent' => $request->is_permanent_address,
            'permanent_address_line1' => $request->permanent_address_line1,
            'permanent_address_line2' => $request->permanent_address_line2,
            'permanent_location' => $request->permanent_location,
            'permanent_landmark' => $request->permanent_landmark,
            'permanent_city' => $request->permanent_city,
            'permanent_pincode' => $request->permanent_pincode,
            'permanent_state' => $request->permanent_state,
            'permanent_country' => $request->permanent_country,
            'current_address_line1' => $request->current_address_line1,
            'current_address_line2' => $request->current_address_line2,
            'current_location' => $request->current_location,
            'current_landmark' => $request->current_landmark,
            'current_city' => $request->current_city,
            'current_pincode' => $request->current_pincode,
            'current_state' => $request->current_state,
            'current_country' => $request->current_country,
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Address created successfully',
                'studentAddresses' => new StudentAddressResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Address',
        ]);
    }
    public function editItemData(Request $request)
    {
        $studentAddress = StudentAddress::where('admission_id', $request->admission)->first();
        if ($studentAddress) return response([
            'status' => 'success',
            'status_code' => 200,
            'edit_address' => new StudentAddressResource($studentAddress),
            'message' => ''
        ]);

        return response([
            'status' => 'error',
            'edit_address' => null,
            'message' => ''
        ]);
    }
    public function updateData(Request $request , StudentAddress $studentAddress)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $updated = $studentAddress->update([
            'isCurrent' => $request->is_current_address,
            'isPermanent' => $request->is_permanent_address,
            'permanent_address_line1' => $request->permanent_address_line1,
            'permanent_address_line2' => $request->permanent_address_line2,
            'permanent_location' => $request->permanent_location,
            'permanent_landmark' => $request->permanent_landmark,
            'permanent_city' => $request->permanent_city,
            'permanent_pincode' => $request->permanent_pincode,
            'permanent_state' => $request->permanent_state,
            'permanent_country' => $request->permanent_country,
            'current_address_line1' => $request->current_address_line1,
            'current_address_line2' => $request->current_address_line2,
            'current_location' => $request->current_location,
            'current_landmark' => $request->current_landmark,
            'current_city' => $request->current_city,
            'current_pincode' => $request->current_pincode,
            'current_state' => $request->current_state,
            'current_country' => $request->current_country,
        ]);

        if ($updated) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Address updated successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Address',
        ]);
    }

}
