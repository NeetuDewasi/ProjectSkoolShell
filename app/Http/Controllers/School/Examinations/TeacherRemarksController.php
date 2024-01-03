<?php

namespace App\Http\Controllers\School\Examinations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Resources\School\Examinations\AssignMarksResource;
use App\Http\Resources\School\Examinations\TeacherRemarkResource;
use App\Models\AssignExamMark;
use App\Models\TeacherRemark;
use App\Http\Controllers\Controller;
use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Models\Admission;
use Illuminate\Http\Request;

class TeacherRemarksController extends Controller
{
    public function getStudents(Request $request)
    {

    $getStudent = AssignExamMark::where('examgroup_id', $request->examgroup_id)->where('exam_id', $request->exam_id)
        ->get();

        if (count($getStudent) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'exam_students' =>AssignMarksResource::collection($getStudent),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'exam_students' => null,
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

        foreach ($request->admission_id as $key => $value) {
            $created = TeacherRemark::create([
                'school_id' => $activeSchool->id,
                'examgroup_id' => $request->exam_groupId,
                'exam_id' => $request->exam_id,
                'admission_id' => $value,
                'remarks' => $request->remarks[$key],
            ]);

            if ($created) {
                return response([
                    'status' => 'success',
                    'status_code' => 201,
                    'teacher_remarks' => new TeacherRemarkResource($created),
                    'message' => 'Exam created successfully',
                ]);
            }
        }
    }
}
