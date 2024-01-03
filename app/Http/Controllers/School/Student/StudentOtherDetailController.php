<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentOtherDetail;
use App\Http\Resources\School\Student\StudentOtherDetailResource;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StudentOtherDetailController extends Controller
{
    public function saveData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $studentOtherDetail = StudentOtherDetail::where('school_id', $activeSchool->id)->where('admission_id', $request->admission_id)->first();

        if ($studentOtherDetail) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This StudentOtherDetail is already exist'
        ]);

        $created = StudentOtherDetail::create([
            'school_id' => $activeSchool->id,
            'admission_id' => $request->admission_id,
            'national_identification_number' => $request->national_identification_number,
            'local_identification_number' => $request->local_identification_number,
            'rte' => $request->rte,
            'previous_school' => $request->previous_school,
            'note' => $request->note,

        ]);
        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'OtherDetail created successfully',
                'studentAddresses' => new StudentOtherDetailResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create StudentOtherDetail',
        ]);
    }

    public function getEditItemData(Request $request)
    {
        $studentDetail = StudentOtherDetail::where('admission_id', $request->admission)->first();
        if ($studentDetail) return response([
            'status' => 'success',
            'status_code' => 200,
            'student_other_detail' => new StudentOtherDetailResource($studentDetail),
            'message' => ''
        ]);

        return response([
            'status' => 'error',
            'edit_Detail' => null,
            'message' => ''
        ]);
    }

    public function updateData(Request $request , StudentOtherDetail $studentOtherDetail)
    {
        $updated = $studentOtherDetail->update([
            'national_identification_number' => $request->national_identification_number,
            'local_identification_number' => $request->local_identification_number,
            'rte' => $request->rte,
            'previous_school' => $request->previous_school,
            'note' => $request->note,

        ]);
        if ($updated) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'OtherDetail updated successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update StudentOtherDetail',
        ]);
    }
}
