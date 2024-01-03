<?php

namespace App\Http\Controllers\School\Examinations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\School\Examinations\AddExamSubjectResource;
use App\Http\Resources\School\Examinations\ExamGroupDropdownResource;
use App\Models\AddExamSubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ExamGroup;
use App\Models\AddNewExam;
use App\Models\User;

class AddExamSubjectController extends Controller
{
    public function saveData(Request $request)
    {
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        foreach ($request->subjects as $key => $value) {
            $created = AddExamSubject::create([
                'school_id' => $activeSchool->id,
                'examgroup_id' => $request->examgroup_id,
                'exam_id' => $request->exam_id,
                'exam_date' => $request->date_from[$key],
                'exam_time' => $request-> start_time[$key],
                'duration' => $request-> duration[$key],
                'room_no' => $request-> room_no[$key],
                'max_marks' => $request-> max_marks[$key],
                'min_marks' => $request-> min_marks[$key],
                'subject_id' => $value,
            ]);
        }
        return response([
            'status' => 'success',
            'status_code' => 201,
            'message' => 'exam subject created successfully',
        ]);
    }
    public function getExamSubject(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        $getExamSubject = AddExamSubject::where('examgroup_id', $request->examgroup_id)->where('exam_id', $request->exam_id)->active()->get();

        if (count($getExamSubject) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'exam_subjects' =>  AddExamSubjectResource::collection($getExamSubject),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'exam_subjects' => null,
            'message' => 'No Exam created yet'
        ]);
    }

}
