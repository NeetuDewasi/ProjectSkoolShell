<?php

namespace App\Http\Controllers\School\Examinations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Resources\School\Examinations\AddNewExamResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\School\Examinations\ExamGroupResource;
use App\Http\Resources\School\Examinations\ExamNamesDropdownResource;
use App\Http\Resources\School\Examinations\ExamTypeResource;
use App\Models\AddNewExam;
use App\Models\ExamGroup;
use App\Models\ExamType;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function getExamNames(ExamGroup $examGroup, Request $request, AddNewExam $addNewExam)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $examNames = AddNewExam::where('exam_group_id', $examGroup->id)->where('school_id', $activeSchool->id)->allowed()->get();

        if (count($examNames) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'exam_names' => AddNewExamResource::collection($examNames),
            'exam_group' => new ExamGroupResource($examGroup),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'exam_names' => null,
            'message' => 'No Exam created yet'
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

        // $newExam = AddNewExam::where('id', $request->id)->first();
        // if ($newExam) return response([
        //     'status' => 'warning',
        //     'status_code' => 300,
        //     'message' => 'This Exam is already exist'
        // ]);
        $created = AddNewExam::create([
            'school_id' => $activeSchool->id,
            'session_id' => $request->session_id,
            'exam_group_id' => $request->group_id,
            'exam_name' => $request->exam_name,
            'publish' => $request->is_publish,
            'publish_result' => $request->publishResult,
            'roll_no' => $request->rollNo,
            'description' => $request->description,
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'new_exam' => new AddNewExamResource($created),
                'message' => 'Exam created successfully',
            ]);
        }

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Exam',
        ]);
    }
    public function getExams(ExamGroup $examGroup, Request $request, AddNewExam $addNewExam)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        $getExams = AddNewExam::where('exam_group_id', $request->examgroup_id)->where('id', $request->exam_id)->active()->first();

        if ($getExams) return response([
            'status' => 'success',
            'status_code' => 200,
            'exams' => new ExamNamesDropdownResource($getExams),
            'exam_names' => new AddNewExamResource($getExams),
            'message' => ''
        ]);

        return response([
            'status' => 'warning',
            'status_code' => 300,
            'exam_names' => null,
            'message' => 'No Exam created yet'
        ]);
    }
    public function getEditItemData(AddNewExam $addNewExam)
    {
        // $getExams = AddNewExam::where('id', $addNewExam->id)->active()->first();
        return response([
            'status' => 'success',
            'status_code' => 200,
            'exam_details' => new AddNewExamResource($addNewExam),
            'message' => ''
        ]);
    }
    public function updateData(Request $request, AddNewExam $addNewExam)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $update = $addNewExam->update([
            'school_id' => $activeSchool->id,
            'session_id' => $request->session_id,
            'exam_group_id' => $request->group_id,
            'exam_name' => $request->exam_name,
            'publish' => $request->is_publish,
            'publish_result' => $request->publishResult,
            'roll_no' => $request->rollNo,
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
    public function changeStatusData(Request $request, AddNewExam $addNewExam)
    {
        if ($request->status == 'deleted') {
            $updated = $addNewExam->update(['status' => $request->status]);
        } else if ($request->status == 'published') {
            $updated = $addNewExam->update(['status' => $request->status, 'published_at' => date('Y-m-d')]);
        } else {
            $updated = $addNewExam->update(['status' => $request->status, 'published_at' => date('Y-m-d')]);
        }
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
