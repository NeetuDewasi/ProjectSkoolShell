<?php

namespace App\Http\Controllers\School\Academics;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Academics\SubjectResource;
use App\Http\Resources\School\Academics\TeacherListResource;
use App\Http\Resources\School\Academics\TeacherResource;
use App\Http\Resources\School\Academics\TeacherSubjectResource;
use App\Http\Resources\School\Academics\getEmployeeDropdownResource;
use App\Models\Employee;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SchoolTeacherController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $teachers = Employee::where('school_id', $activeSchool->id)->teacher()->get();
        $schoolSubjects = Subject::where('school_id', $activeSchool->id)->active()->get();

        if (count($teachers) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'teachers' => TeacherResource::collection($teachers),
            'school_subjects' => SubjectResource::collection($schoolSubjects),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'teachers' => null,
            'message' => 'No teacher yet'
        ]);
    }

    public function getTeacherSubjectData(Request $request)
    {
        $teacher = Employee::where('id', $request->teacher)->with('subjects')->first();
        if ($teacher) return response([
            'status' => 'success',
            'teacher_subjects' => TeacherSubjectResource::collection($teacher->subjects),
            'message' => ''
        ]);

        return response([
            'status' => 'error',
            'teacher_subjects' => null,
            'message' => 'Teacher Subject Not Assign',
        ]);
    }

    public function assignSubjectData(Request $request, Employee $employee)
    {
        $employee->subjects()->sync(explode(",", $request->subject_ids));

        return response(([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'teacher subject update successfully!'
        ]));
    }

    public function getSubjctTeacher(Request $request)
    {
        $subject = Subject::where('id', $request->subject)->with('teachers')->first();
        return response([
            'status' => 'success',
            'teachers' => TeacherListResource::collection($subject->teachers)
        ]);
    }
    public function getTeacherList(){
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $teachers = Employee::where('school_id', $activeSchool->id)->teacher()->get();

        if (count($teachers) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'teachers' => getEmployeeDropdownResource::collection($teachers),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'teachers' => null,
            'message' => 'No teacher yet'
        ]);
    }
}
