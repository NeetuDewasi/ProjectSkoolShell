<?php

namespace App\Http\Controllers\School\Examinations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Resources\School\Examinations\EnterMarksResource;
use App\Http\Resources\School\Examinations\AssignMarksResource;
use App\Http\Resources\School\Examinations\AddExamSubjectResource;
use App\Http\Resources\School\Examinations\ExamGroupResource;
use App\Http\Controllers\Controller;
use App\Models\AssignExamMark;
use App\Models\AddExamSubject;
use App\Models\ExamGroup;
use Illuminate\Http\Request;

class AssignMarksController extends Controller
{
    public function saveData(Request $request)
    {

        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        foreach ($request->admission_id as $key => $value) {
            $created = AssignExamMark::create([
                'school_id' => $activeSchool->id,
                'examgroup_id' => $request->exam_groupId,
                'exam_id' => $request->exam_id,
                'addexam_subject_id' => $request->subject_id,
                'admission_id' => $value,
                'session_id' => $request->session_id,
                'school_class_id' => $request->class_id,
                'school_section_id' => $request->section_id,
                'absent	' => $request->absent[$key],
                'obtained_marks' => $request->marks[$key],
                'note' => $request->note[$key],
            ]);
        }
            if ($created) {
                return response([
                    'status' => 'success',
                    'status_code' => 201,
                    'assign_marks' => new EnterMarksResource($created),
                    'message' => 'Exam created successfully',
                ]);
            }

    }
    public function getExamSubjectData(Request $request)
    {

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

    public function getResult(Request $request)
    {
        $result = AssignExamMark::where('examgroup_id', $request->examgroup_id)->where('exam_id', $request->exam_id)->
        where('school_class_id',$request->class_id)->where('school_section_id', $request->section_id)->active()->get();
        if ($result && count($result) > 0) {
            return response([
                'status' => 'success',
                'status_code' => 200,
                'results' => AssignMarksResource::collection($result),
                'message' => ''
            ]);
        } else {
            return response([
                'status' => 'warning',
                'status_code' => 300,
                'results' => null,
                'message' => 'No Exam created yet'
            ]);
        }
    }
}
