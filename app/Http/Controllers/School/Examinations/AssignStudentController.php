<?php

namespace App\Http\Controllers\School\Examinations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\AssignStudent;
use App\Models\Admission;
use App\Http\Resources\School\Examinations\AssignStudentResource;
use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Http\Resources\School\DownloadCenter\DownloadContentStudentResource;

class AssignStudentController extends Controller
{
    public function getClassStudentData(Request $request)
    {
        $studentAdmissions = array();
        if ($request->has('class_id') && $request->class_id != '-1') {
            if ($request->has('section_id') && $request->section_id != '-1') {
                $studentAdmissions = Admission::where('school_class_id', $request->class_id)->where('school_section_id', $request->section_id)->get();
            } else {
                $studentAdmissions = Admission::where('school_class_id', $request->class_id)->get();
            }
        } else {
            return response([
                'status' => 'warning',
                'status_code' => 300,
                'student_admissions' => null,
                'message' => 'No admission created yet'
            ]);
        }

        if (count($studentAdmissions) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'students' => StudentAdmissionResource::collection($studentAdmissions),
            'student_admissions' => DownloadContentStudentResource::collection($studentAdmissions),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_admissions' => null,
            'message' => 'No admission created yet'
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

        $newExam = AssignStudent::where('admission_id', $request->admission_ids)->first();
        if ($newExam) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Exam is already exist'
        ]);
        $created = AssignStudent::create([
            'school_id' => $activeSchool->id,
            'examgroup_id' => $request->exam_groupId,
            'exam_id' => $request->exam_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'admission_id' => json_encode($request->admission_ids),
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'assign_exam' => new AssignStudentResource($created),
                'message' => 'Exam created successfully',
            ]);
        }

    }
}
