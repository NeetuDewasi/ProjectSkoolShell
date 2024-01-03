<?php

namespace App\Http\Controllers\School\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Attendance\StudentAttendanceResource;
use App\Models\Admission;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\SchoolSection;
use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StudentAttendanceController extends Controller
{
    public function getData(Request $request)
    {
        // return dd('class', $request->school_class_id,'section', $request->school_section_id,'date', $request->attendance_date);
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;

        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }


        $students = Admission::where('school_id', $activeSchool->id)->where('school_class_id', $request->school_class_id)->where('school_section_id', $request->school_section_id)->with(['attendances' => function($query) use($request) {
            return $query->where('date', $request->attendance_date);
        }])->get();

        if (count($students) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'students' => StudentAttendanceResource::collection($students),
            'message' => ''
        ]);

        return response([
            'status' => 'warning',
            'status_code' => 300,
            'students' => null,
            'message' => 'No attendance created yet'
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

        $studentAttendance = json_decode($request->student_attendance);

        foreach ($studentAttendance as $attendance) {
            $studentAttendance = StudentAttendance::where('admission_id', $attendance->id)->where('date', $request->attendance_date)->first();
            if($studentAttendance) {
               $update = $studentAttendance->update([
                   'attendance' => $attendance->attendance
               ]);
            } else {
                StudentAttendance::create([
                    'school_id' => $activeSchool->id,
                    'admission_id' => $attendance->id,
                    'date'=> date_format(date_create($request->attendanceDate), 'Y-m-d'),
                    'attendance' => $attendance->attendance,
                ]);
            }
        }

        return response([
            'status' => 'success',
            'status_code' => 201,
            'message' => 'attendance created successfully',
        ]);
    }

     public function getAttendanceReportData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;

        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $students = Admission::where('school_id', $activeSchool->id)->where('school_class_id', $request->school_class_id)->where('school_section_id', $request->school_section_id)->with(['attendances' => function($query) use($request) {
            return $query->where('date', $request->attendance_date);
        }])->get();

        if (count($students) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'students' => StudentAttendanceResource::collection($students),
            'message' => ''
        ]);

        return response([
            'status' => 'warning',
            'status_code' => 300,
            'students' => null,
            'message' => 'No attendance created yet'
        ]);
    }


}
