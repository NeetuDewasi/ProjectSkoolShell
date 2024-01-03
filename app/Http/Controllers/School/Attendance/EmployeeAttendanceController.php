<?php

namespace App\Http\Controllers\School\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Attendance\EmployeeAttendanceResource;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EmployeeAttendanceController extends Controller
{
    public function getData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;

        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }


        $employees = Employee::where('school_id', $activeSchool->id)->where('department_id', $request->department_id)->with(['attendances' => function($query) use($request) {
            return $query->where('date', $request->attendance_date);
        }])->get();

        if (count($employees) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'employees' => EmployeeAttendanceResource::collection($employees),
            'employees_on_leave' => EmployeeAttendanceResource::collection($employees),
            'message' => ''
        ]);

        return response([
            'status' => 'warning',
            'status_code' => 300,
            'employees' => null,
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

        $employeeAttendance = json_decode($request->employee_attendance);

        foreach ($employeeAttendance as $attendance) {
            $employeeAttendance = EmployeeAttendance::where('employee_id', $attendance->id)->where('date', $request->attendance_date)->first();
            if($employeeAttendance) {
               $update = $employeeAttendance->update([
                   'attendance' => $attendance->attendance
               ]);
            } else {
                EmployeeAttendance::create([
                    'school_id' => $activeSchool->id,
                    'employee_id' => $attendance->id,
                    'date'=> date_format(date_create($request->attendance_date), 'Y-m-d'),
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

        $employees = Employee::where('school_id', $activeSchool->id)->where('department_id', $request->department_id)->with(['attendances' => function($query) use($request) {
            return $query->where('date', $request->attendance_date);
        }])->get();

        if (count($employees) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'employees' => EmployeeAttendanceResource::collection($employees),
            'message' => ''
        ]);

        return response([
            'status' => 'warning',
            'status_code' => 300,
            'employees' => null,
            'message' => 'No attendance created yet'
        ]);
    }
}
