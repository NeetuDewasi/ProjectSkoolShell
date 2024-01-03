<?php

namespace App\Http\Controllers\School\Examinations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Resources\School\Examinations\ExamTypeResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\School\Examinations\ExamTypeDropdownResource;
use App\Models\ExamType;
use Illuminate\Http\Request;

class ExamTypesController extends Controller
{
    public function saveData(Request $request)
    {

        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $exam_type = ExamType::where('id', $request->id)->first();
        if ($exam_type) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Exam is already exist'
        ]);
        $created = ExamType::create([
            'school_id' => $activeSchool->id,
            'name' => $request->exam_type,
            'details' => $request->description,
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'exam_type' => new ExamTypeResource($created),
                'message' => 'Exam Type created successfully',
            ]);
        }

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Exam',
        ]);
    }
    public function showData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $examTypes = ExamType::where('school_id', $activeSchool->id)->active()->get();
        if (count($examTypes) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'exam_list' => ExamTypeDropdownResource::collection($examTypes),
            'examType_list' => ExamTypeResource::collection($examTypes),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'examType_list' => null,
            'message' => 'No Exam created yet'
        ]);
    }
    public function updateData(Request $request, ExamType $examType)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $update = $examType->update([
            'school_id' => $activeSchool->id,
            'name' => $request->exam_type,
            'description' => $request->description,

        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Exam Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Exam',
        ]);
    }
    public function changeStatusData(Request $request, ExamType $examType)
    {
        $updated = $examType->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Exam successfully ' . $request->status,
        ]);

        if ($request->status == 'activated') $message =
            'activate';
        else if ($request->status == 'deactivated') $message =
            'dectivate';
        else if ($request->status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
