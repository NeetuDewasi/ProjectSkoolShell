<?php

namespace App\Http\Controllers\School\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Common\ClassListResource;
use App\Http\Resources\school\Front_Office\AdmissionEnquiryResource;
use App\Http\Resources\School\Front_Office\EnquiryStudentResource;
use App\Http\Resources\School\Front_Office\ReferenceDropDownResouce;
use App\Http\Resources\School\Front_Office\SourceDropDownResource;
use App\Models\Admission;
use App\Models\AdmissionEnquiry;
use App\Models\Enquirystudent;
use App\Models\Reference;
use App\Models\SchoolClass;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdmissionEnquiryController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $enquiries= Enquirystudent::where('school_id',$activeSchool->id)->allowed()->get();
        if(count($enquiries) > 0) return response([
            'status' => 'success',
            'status_code' =>200,
            'enquiries' => EnquiryStudentResource::collection($enquiries),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'enquiries' => null,
            'message' => 'No Enquiries add yet..',
        ]);
    }
    public function getClassData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $classes= SchoolClass::where('school_id',$activeSchool->id)->allowed()->get();

        return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'class_list' => $classes && count($classes) > 0 ? ClassListResource::collection($classes) : null,

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

        $enquiry = AdmissionEnquiry::where('id', $request->admission_enquiry_id)->where('school_id', $activeSchool->id)->allowed()->first();
        $enquiryStudent = Enquirystudent::where('id', $request->enquiry_student_id)->where('admission_enquiry_id', $request->enquiry_admission_id)->where('school_id', $activeSchool->id)->allowed()->first();
        if($enquiry) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Enuieries already exits'
        ]);

        $created = AdmissionEnquiry::create([
            'school_id'=> $activeSchool->id,
            'user_id'=>$user->id,
            'name' => $request->admission_enquiry_name,
            'phone' => $request->admission_enquiry_phone,
            'email' => $request->admission_enquiry_email,
            'address_line1' => $request->admission_enquiry_address_line1,
            'address_line2' => $request->admission_enquiry_address_line2,
            'area' => $request->admission_enquiry_area,
            'location' => $request->admission_enquiry_location,
            'landmark' => $request->admission_enquiry_landmark,
            'city' => $request->admission_enquiry_city,
            'state' => $request->admission_enquiry_state,
            'country' => $request->admission_enquiry_country,
            'pincode' => $request->admission_enquiry_pincode,
            'note' => $request->admission_enquiry_note,
            'no_of_child' => $request->admission_enquiry_no_of_child,
        ]);

        foreach ($request->enquiry_student_name as $key => $value) {
            $createEnquiryStudent = Enquirystudent::create([
                'school_id' => $activeSchool->id,
                'admission_enquiry_id' =>  $created->id,
                'school_class_id' => $request->enquiry_student_class[$key],
                'name' => $value,
            ]);
        }

        if($created){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Enquiry Created Successfully',
                'enquiry' => new AdmissionEnquiryResource($created)
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Enquiries',
        ]);
    }

    public function getEditData(AdmissionEnquiry $admission_enquiry)
    {
        return response([
            'status' => 'success',
            'admission_enquiry' => new AdmissionEnquiryResource($admission_enquiry),
        ]);
    }

    public function updateData(Request $request , AdmissionEnquiry $admission_enquiry)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }

        $alreadyExit = AdmissionEnquiry::where('id', $request->admission_enquiry_id)->where('email', $request->admission_enquiry_email)->where('school_id', $activeSchool->id)->where('id', '!=', $admission_enquiry->id)->allowed()->first();

        if($alreadyExit) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Enuieries already exits'
        ]);

        $update = $admission_enquiry->update([
            'name' => $request->admission_enquiry_name,
            'phone' => $request->admission_enquiry_phone,
            'email' => $request->admission_enquiry_email,
            'address_line1' => $request->admission_enquiry_address_line1,
            'address_line2' => $request->admission_enquiry_address_line2,
            'area' => $request->admission_enquiry_area,
            'location' => $request->admission_enquiry_location,
            'landmark' => $request->admission_enquiry_landmark,
            'city' => $request->admission_enquiry_city,
            'state' => $request->admission_enquiry_state,
            'country' => $request->admission_enquiry_country,
            'pincode' => $request->admission_enquiry_pincode,
            'note' => $request->admission_enquiry_note,
        ]);

        $childs = Enquirystudent::where('admission_enquiry_id' ,$admission_enquiry->id )->get();
        if($childs){
            foreach ($childs as $key => $value) {
                $updateStudents = $value->update([
                    'school_class_id' => $request->enquiry_student_class[$key],
                    'name' => $request->enquiry_student_name[$key],
                ]);
            }
        }

        if($update){
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Enquiries Updated Successfully',
                'enquiry' => new AdmissionEnquiryResource($admission_enquiry),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Enquieries',
        ]);
    }

    public function changeStatusData(Request $request, Enquirystudent $enquiry_student)
    {
        $update = $enquiry_student->update(['status' => $request->enquiry_student_status]);
        if ($update) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Enquiries data successfully ' . $request->enquiry_student_status,
        ]);


        if ($request->enquiry_student_status == 'activated') $message = 'activate';
        else if ($request->enquiry_student_status == 'deactivated') $message = 'dectivate';
        else if ($request->enquiry_student_status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }

    public function getAdmissionEnquiryData(Enquirystudent $enquiry_student)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $enquiry_student = Enquirystudent::where('id' , $enquiry_student->id)->with('admissionEnquiry')->where('school_id',$activeSchool->id)->allowed()->first();
        return response([
            'status' => 'success' ,
            'enquiry_student' =>new EnquiryStudentResource($enquiry_student),
            'message' => '',
        ]);
    }
}
