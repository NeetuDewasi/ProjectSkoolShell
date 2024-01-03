<?php

namespace App\Http\Controllers\School\Communicate;

use App\Http\Controllers\Controller;
use App\Models\EmailSMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Message;
use App\Models\Department;
use App\Http\Resources\School\Human_Resource\DepartmentDropDownResource;
use App\Http\Resources\School\Human_Resource\DepartmentResource;
use App\Http\Resources\School\Communication\EmployeeListDropdownResource;
use App\Http\Resources\School\Communication\SendMessageResource;
use App\Models\Employee;

class EmailSMSController extends Controller
{
    public function getDepartment()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $department = Department::where('school_id', $activeSchool->id)->get();
        if (count($department) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'department' => DepartmentResource::collection($department),
            'message' => '',
        ]);
    }
    public function getDepartmentDropdown(Department $departments)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $departments = Department::where('school_id', $activeSchool->id)->get();
        if (count($departments) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'departments' => DepartmentDropDownResource::collection($departments),

            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'departments' => null,
            'message' => 'No departments added yet..',
        ]);
    }
    public function selectedDepartmentList(Request $request)
    {
        if ($request->has('departmentId') && $request->departmentId != '-1') {

            $employeeList = Employee::where('department_id', $request->departmentId)->get();
        } else {
            return response([
                'status' => 'warning',
                'status_code' => 300,
                'employees' => null,
                'message' => 'No employee created yet'
            ]);
        }
        if (count($employeeList) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'employees' =>  EmployeeListDropdownResource::collection($employeeList),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'employees' => null,
            'message' => 'No employees created yet'
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
        $email_sms = Message::where('title', $request->title)->first();
        if ($email_sms) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This message is already exist'
        ]);
        $created = Message::create([
            'school_id' => $activeSchool->id,
            'user_id' => $user->id,
            'title' => $request->title,
            'email' => $request->email,
            'sms' => $request->sms,
            'content' => $request->content,
            'message_for' => $request->message_for,
            'receiver_ids' => json_encode($request->receiver_ids)
        ]);
        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'message created successfully',
                'email_sms' => new SendMessageResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create message',
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
        $email_sms = Message::where('school_id', $activeSchool->id)->active()->get();
        if (count($email_sms) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'email_sms' => SendMessageResource::collection($email_sms),
            'message' => '',
        ]);
    }
    public function getEditItemData(Message $message)
    {
        return response([
            'status' => 'success',
            'status_code' => 200,
            'edited_email_sms' => new SendMessageResource($message),
            'message' => ''
        ]);
    }
    public function getViewPageData(Message $message)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $view_emailSMS = Message::where('id', $message->id)->allowed()->first();
        return response([
            'status' => 'success',
            'status_code' => 200,
            'view_email_sms' => new SendMessageResource($message),
            'message' => ''
        ]);
    }
    public function updateData(Request $request, Message $message)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $update = $message->update([
           'school_id' => $activeSchool->id,
            'user_id' => $user->id,
            'title' => $request->message_title,
            'email' => $request->message_email,
            'sms' => $request->message_sms,
            'content' => $request->message_content,
            'message_for' => $request->message_for,
            'receiver_ids' => json_encode($request->receiver_ids)
        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 200,
                'message' => 'message updated successfully',

            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update message',
        ]);
    }
    public function changeStatusData(Request $request, Message $message)
    {
        $updated = $message->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'message  successfully ' . $request->status,
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
