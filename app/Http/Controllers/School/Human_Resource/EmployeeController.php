<?php

namespace App\Http\Controllers\School\Human_Resource;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Human_Resource\DepartmentDropDownResource;
use App\Http\Resources\School\Human_Resource\DesignationDropDownResource;
use App\Http\Resources\School\Human_Resource\EmployeeDocumentResource;
use App\Http\Resources\School\Human_Resource\EmployeeResource;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $employees= Employee::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($employees) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'employees' =>EmployeeResource::collection($employees),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'employees' => null,
            'message' => 'No Employees add yet..',
        ]);
    }

    public function getDesignationDepartmentData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $designation= Designation::where('school_id',$activeSchool->id)->get();
        $department= Department::where('school_id',$activeSchool->id)->get();

        return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'designation_list' => $designation && count($designation) > 0 ? DesignationDropDownResource::collection($designation) : null,
            'department_list' => $department && count($department) > 0 ? DepartmentDropDownResource::collection($department) : null,
        ]);
    }

    public function saveBasicInformationData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $employee = Employee::where('registration_id', $request->employee_registration_id)->where('school_id', $activeSchool->id)->first();
        if($employee) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Employee already exits'
        ]);

        $imagePath = null;
        if($request->hasFile('employee_photo') && $request->employee_photo != null && $request->employee_photo != '' ) {
            $imagePath = $request->employee_photo->store('employees/profile_pics');
        }


        $created = Employee::create([
            'school_id'=> $activeSchool->id,
            'department_id' => $request->employee_department,
            'registration_id' => $request->employee_registration_id,
            'first_name' => $request->employee_first_name,
            'last_name' => $request->employee_last_name,
            'father_name' => $request->employee_father_name,
            'mother_name' => $request->employee_mother_name,
            'email' => $request->employee_email,
            'gender' => $request->employee_gender,
            'dob' => date_format(date_create($request->employee_dob), 'Y-m-d'),
            'date_of_join' => date_format(date_create($request->employee_date_of_join), 'Y-m-d'),
            'mobile' => $request->employee_mobile,
            'emergency_contact_name' => $request->employee_ecp,
            'emergency_contact_number' => $request->employee_ecn,
            'marital_status' => $request->employee_marital_status,
            'photo' => $imagePath,
        ]);
        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Employee Created Successfully',
                'employee' => new EmployeeResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Employee',
        ]);
    }

    public function updateBasicInformationData(Request $request, Employee $employee)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }

        if($employee->school_id != $activeSchool->id) return response([
            'status' => 'error',
            'status_code' => 501,
            'message' => 'Unauthorized',
        ]);

        $imagePath = $employee->photo;
        if($request->hasFile('employee_photo') && $request->employee_photo != null && $request->employee_photo != '' ) {
            if($employee->photo != null) {
                Storage::delete($employee->photo);
            }
            $imagePath = $request->employee_photo->store('employees/profile_pics');
        }

        $updated = $employee->update([
            'department_id' => $request->employee_department,
            'registration_id' => $request->employee_registration_id,
            'first_name' => $request->employee_first_name,
            'last_name' => $request->employee_last_name,
            'father_name' => $request->employee_father_name,
            'mother_name' => $request->employee_mother_name,
            'email' => $request->employee_email,
            'gender' => $request->employee_gender,
            'dob' => date_format(date_create($request->employee_dob), 'Y-m-d'),
            'date_of_join' => date_format(date_create($request->employee_date_of_join), 'Y-m-d'),
            'mobile' => $request->employee_mobile,
            'emergency_contact_name' => $request->employee_ecp,
            'emergency_contact_number' => $request->employee_ecn,
            'marital_status' => $request->employee_marital_status,
            'photo' => $imagePath,
        ]);
        if($updated){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Employee updated Successfully',
                'employee' => new EmployeeResource(Employee::find($employee->id)),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Employee',
        ]);
    }


    public function updateAddressData(Request $request, Employee $employee)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }

        if($employee->school_id != $activeSchool->id) return response([
            'status' => 'error',
            'status_code' => 501,
            'message' => 'Unauthorized',
        ]);

        $imagePath = $employee->photo;
        if($request->hasFile('employee_photo') && $request->employee_photo != null && $request->employee_photo != '' ) {
            if($employee->photo != null) {
                Storage::delete($employee->photo);
            }
            $imagePath = $request->employee_photo->store('employees/profile_pics');
        }
        $message = 'Employee address created successfully';
        if($employee->current_address1) {
            $message = 'Employee address updated successfully';
        }

        $updated = $employee->update([
            'current_address1' => $request->employee_current_address1,
            'current_address2' => $request->employee_current_address2,
            'current_area' => $request->employee_current_area,
            'current_location' => $request->employee_current_location,
            'current_city' => $request->employee_current_city,
            'current_state' => $request->employee_current_state,
            'current_country' => $request->employee_current_country,
            'current_pincode' => $request->employee_current_pincode,
            'is_same_address' => $request->is_same_address,
            'permanent_address1' => $request->employee_permanent_address1,
            'permanent_address2' => $request->employee_permanent_address2,
            'permanent_area' => $request->employee_permanent_area,
            'permanent_location' => $request->employee_permanent_location,
            'permanent_landmark' => $request->employee_permanent_landmark,
            'permanent_city' => $request->employee_permanent_city,
            'permanent_state' => $request->employee_permanent_state,
            'permanent_country' => $request->employee_permanent_country,
            'permanent_pincode' => $request->employee_permanent_pincode,
        ]);
        if($updated){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => $message,
                'employee' => new EmployeeResource(Employee::find($employee->id)),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Employee',
        ]);
    }

    public function updateDocumentData(Request $request, Employee $employee)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }

        if($employee->school_id != $activeSchool->id) return response([
            'status' => 'error',
            'status_code' => 501,
            'message' => 'Unauthorized',
        ]);
        $document_file_path = null;
        if ($request->has('document_files')) {
            $files = array();
            $files['path'] = array();

            $file_path = null;
            $documents =  $request->file('document_files');

            foreach ($documents as $document) {
                $file_path = '/storage/' . $document->store('employees/' . $user->id . '/documents');
                array_push($files['path'], $file_path);
            }
            $document_file_path = $files;
        }
        $created = EmployeeDocument::create([
            'school_id' => $activeSchool->id,
            'employee_id' => $employee->id,
            'type' => $request->document_type,
            'document' => json_encode($document_file_path),
            'description' => null,
        ]);
        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'File uploaded',
                'employee_document' => new EmployeeDocumentResource($created),

            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update file',
        ]);
    }
    public function saveData(Request $request)
    {

        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $employee = Employee::where('staff_id', $request->employee_staff_id)->where('school_id', $activeSchool->id)->first();
        if($employee) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Employee already exits'
        ]);
        $created = Employee::create([
            'school_id'=> $activeSchool->id,
            'designation_id' =>  $request->employee_designation,
            'department_id' => $request->employee_department,
            'staff_id' => $request->employee_staff_id,
            'first_name' => $request->employee_f_name,
            'last_name' => $request->employee_l_name,
            'father_name' => $request->employee_father_name,
            'mother_name' => $request->employee_mother_name,
            'email' => $request->employee_email,
            'gender' => $request->employee_gender,
            'dob' => date_format(date_create($request->employee_dob), 'Y-m-d'),
            'date_of_join' => date_format(date_create($request->employee_date_of_join), 'Y-m-d'),
            'phone' => $request->employee_phone,
            'alt_number' => $request->employee_alt_phone,
            'marital_status' => $request->employee_marital_status,
            'photo' => $request->employee_photo,

        ]);
        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Employee Created Successfully',
                'employee' => new EmployeeResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Employee',
        ]);
    }

    public function getEditData(Employee $employee)
    {
        return response([
            'status' => 'success',
            'employee' => new EmployeeResource($employee),
        ]);
    }

    public function getEmployeeDownloadData(Employee $employee)
    {
        $employeeDocuments = EmployeeDocument::where('employee_id', $employee->id)->get();
        return response([
            'status' => 'success',
            'employee_documents' => EmployeeDocumentResource::collection($employeeDocuments),
        ]);
    }
    public function saveAddressData(Request $request , Employee $employee)
    {
        $update = $employee->update([
            'current_address1' => $request->employee_current_address1,
            'current_address2' => $request->employee_current_address2,
            'current_area' => $request->employee_current_area,
            'current_location' => $request->employee_current_location,
            'current_city' => $request->employee_current_city,
            'current_state' => $request->employee_current_state,
            'current_country' => $request->employee_current_country,
            'current_pincode' => $request->employee_current_pincode,
            'permanent_address1' => $request->employee_permanent_address1,
            'permanent_address2' => $request->employee_permanent_address2,
            'permanent_area' => $request->employee_permanent_area,
            'permanent_location' => $request->employee_permanent_location,
            'permanent_landmark' => $request->employee_permanent_landmark,
            'permanent_city' => $request->employee_permanent_city,
            'permanent_state' => $request->employee_permanent_state,
            'permanent_country' => $request->employee_permanent_country,
            'permanent_pincode' => $request->employee_permanent_pincode,
        ]);

        if($update){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Employee Address Updated Successfully',
                'employee' => new EmployeeResource($employee),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Employee',
        ]);
    }

    public function changeStatusData(Request $request, Employee $employee)
    {
        $update = $employee->update(['status' => $request->employee_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Enquiries data successfully ' . $request->employee_status,
        ]);

        if ($request->employee_status == 'activated') $message =
            'activate';
        else if ($request->employee_status == 'deactivated') $message =
            'dectivate';
        else if ($request->employee_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }
}
