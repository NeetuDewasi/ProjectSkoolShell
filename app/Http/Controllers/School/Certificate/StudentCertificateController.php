<?php

namespace App\Http\Controllers\School\Certificate;

use App\Http\Controllers\Controller;
use App\Models\StudentCertificate;
use Illuminate\Http\Request;
use App\Http\Resources\School\Certificate\StudentCertificateResource;
use App\Http\Resources\School\Certificate\GenerateCertificateResource;
use App\Http\Resources\School\Certificate\CertificateDropDownResource;
use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Models\Certificate;
use App\Models\Admission;
use App\Models\SchoolClass;
use App\Models\SchoolSection;
use App\Models\GenerateCertificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;


class StudentCertificateController extends Controller
{
     public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $certificate_data = Certificate::where('school_id', $activeSchool->id)->allowed()->get();
        if (count($certificate_data) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'show_certificate_list' => StudentCertificateResource::collection($certificate_data),
            'message' => ''
        ]);

        return response([
            'status' => 'warning',
            'status_code' => 300,
            'certificate_list' => null,
            'message' => 'No Certificate created yet'
        ]);

    }
    public function getDataCertificate(SchoolClass $schoolClass, SchoolSection $schoolSection)
    {
        $studentAdmissions = Admission::where('school_class_id', $schoolClass->id)->where('school_section_id', $schoolSection->id)->allowed()->get();

        if (count($studentAdmissions) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'student_admissions' => StudentAdmissionResource::collection($studentAdmissions),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_admissions' => null,
            'message' => 'No admission created yet'
        ]);
    }
    public function getCertificateList()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $certificate_list = Certificate::where('school_id', $activeSchool->id)->allowed()->get();
        if (count($certificate_list) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'certificateList' => CertificateDropDownResource::collection($certificate_list),
            'message' => ''
        ]);

        return response([
            'status' => 'warning',
            'status_code' => 300,
            'certificateList' => null,
            'message' => 'No Certificate created yet'
        ]);

    }
    public function getGeneratedCertificate(Admission $admission , Certificate $certificate){

        return response([
            'status' => 'success',
            'status_code' => 200,
            'student' => new StudentAdmissionResource($admission),
            'certificateList' => new StudentCertificateResource($certificate),
            'message' => ''
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
        $certificate = Certificate::where('school_id', $activeSchool)->first();
        if ($certificate) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Certificate is already exist'
        ]);

        $background_image = null;
        if ($request->has('background_image') && $request->background_image != '') {
            $background_image = '/storage/' . $request->background_image->store('images/certificates');
        }
        $created = Certificate::create([
            'school_id' => $activeSchool->id,
            'certificate_name' => $request->certificate_name,
            'header_right_text' => $request->header_right_text,
            'header_left_text' => $request->header_left_text,
            'header_center_text' => $request->header_center_text,
            'body_text' => $request->body_text,
            'footer_right_text' => $request->footer_right_text,
            'footer_left_text' => $request->footer_left_text,
            'footer_center_text' => $request->footer_center_text,
            'header_height' => $request->header_height,
            'footer_height' => $request->footer_height,
            'body_width' =>$request->body_width,
            'body_height'  => $request->body_height,
            'student_photo' => $request->student_photo,
            'background_image' => $background_image,
        ]);
        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'certificates' => new StudentCertificateResource($created),
                'message' => 'Certificate Created Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, Unable to create Certificate',
        ]);
    }

    public function getEditData(Certificate $certificate){
        return response([
            'status' => 'success',
            'status_code' => 200,
            'edit_certificate' => new StudentCertificateResource($certificate),
            'message' => ''
        ]);
    }
        public function saveData2(Request $request){
            $authUser = Auth::user();
            $user = User::find($authUser->id);
            $activeSchool = null;
            if (Session::has('active_school_id') && Session::get('active_school_id') !== -1){
            $activeSchool = Session::get('active_school')->first();
            }
            foreach($request->admission_ids as $key=>$value){
                $created = GenerateCertificate::create([
                'school_id' => $activeSchool->id,
                'school_class_id' => $request->class_id ,
                'school_section_id' => $request->section_id,
                'certificate_id'=> $request->certificate_id,
                'admission_id'=> $value,
                'status' => 'activated',
                ]);
                if($created){
                    return response([
                        'status' => 'success',
                        'status_code' => 201,
                        'message' => 'Generate Certificate created successfully',
                    ]);
                }
            }
            return response([
                'status' => 'error',
                'status_code' => 400,
                'message' => 'Something went wrong',
            ]);
        }
        public function updateData(Request $request, Certificate $certificate)
        {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $background_image = '';
        if ($request->has('background_image') && $request->background_image != null && $request->background_image != '') {
            $background_image = '/storage/' . $request->background_image->store('images/certificates');
        }
        $update = $certificate->update([

            'school_id' => $activeSchool->id,
            'certificate_name' => $request->certificate_name,
            'header_right_text' => $request->header_right_text,
            'header_left_text' => $request->header_left_text,
            'body_text' => $request->body_text,
            'footer_right_text' => $request->footer_right_text,
            'footer_left_text' => $request->footer_left_text,
            'footer_center_text' => $request->footer_center_text,
            'header_height' => $request->header_height,
            'footer_height' => $request->footer_height,
            'body_width' => $request->body_width,
            'body_height'  => $request->body_height,
            'student_photo' => $request->student_photo,
            'background_image' => $background_image,
        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Certificate Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Certificate',
        ]);
    }
    public function changeStatusData(Request $request, Certificate $certificate)
    {
        $updated = $certificate->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Certificate successfully ' . $request->status,
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
