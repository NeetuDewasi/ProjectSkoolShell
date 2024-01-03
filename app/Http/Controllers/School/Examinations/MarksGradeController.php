<?php

namespace App\Http\Controllers\School\Examinations;

use App\Http\Resources\School\Examinations\AddMarksGradeResource;
use App\Http\Resources\School\Examinations\ExamTypeDropdownResource;
use App\Http\Controllers\Controller;
use App\Models\MarksGrade;
use App\Models\ExamType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;



class MarksGradeController extends Controller
{
    public function getExamType()
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
            'exam_type_list' => ExamTypeDropdownResource::collection($examTypes),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'exam_type_list' => null,
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

        $created = MarksGrade::create([
            'school_id' => $activeSchool->id,
            'exam_type_id' => $request->exam_type_id,
            'grade_name' => $request->grade_name,
            'percentage_upto' => $request->percent_upto,
            'percentage_from' => $request->percent_from,
            'grade_point' => $request->grade_point,
        ]);
        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Design Marksheet created successfully',
            ]);
            return response([
                'status' => 'error',
                'status_code' => 400,
                'message' => 'Something went wrong',
            ]);
        }
    }
    public function showData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $marks_grade = MarksGrade::where('school_id', $activeSchool->id)->active()->get();
        if (count($marks_grade) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'marks_grade_list' => AddMarksGradeResource::collection($marks_grade),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'marks_grade_list' => null,
            'message' => 'No marksheet created yet'
        ]);
    }
    public function updateData(Request $request, MarksGrade $MarksGrade)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $update = $MarksGrade->update([
            'school_id' => $activeSchool->id,
            'exam_type_id' => $request->exam_type_id,
            'grade_name' => $request->grade_name,
            'percentage_upto' => $request->percent_upto,
            'percentage_from' => $request->percent_from,
            'grade_point' => $request->grade_point,
        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Marks Grade Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Marks Grade',
        ]);
    }
    public function changeStatusData(Request $request, MarksGrade $marksGrade)
    {
        if ($request->status == 'deleted') {
            $updated = $marksGrade->update(['status' => $request->status]);
        }
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Marks Grade successfully ' . $request->status,
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
