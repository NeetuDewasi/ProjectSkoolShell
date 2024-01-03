<?php

namespace App\Http\Controllers\School\Certificate;

use App\Http\Controllers\Controller;
use App\Models\StudentIdCard;
use App\Models\GenerateIdCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Admission;
use App\Http\Resources\School\Certificate\IdCardResource;
use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Http\Resources\School\Certificate\IdCardDropdownResource;

class StudentIdCardController extends Controller
{
    public function saveData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $background_image = null;
        if ($request->has('background_image') && $request->background_image != '') {
            $background_image = '/storage/' . $request->background_image->store('images/id_cards');
        }
        $signature = null;
        if ($request->has('signature') && $request->signature != '') {
            $signature = '/storage/' . $request->signature->store('images/id_cards');
        }
        $logo = null;
        if ($request->has('logo') && $request->logo != '') {
            $logo = '/storage/' . $request->logo->store('images/id_cards');
        }

        $created = StudentIdCard::create([
            'school_id' => $activeSchool->id,
            'school_name' => $request->school_name,
            'id_card_title' => $request->title,
            'header_color' => $request->header_color,
            'address' => $request->address_phone_email,
            'admission_number' => $request->admission_number,
            'student_name' => $request->student_name,
            'class' => $request->class,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'student_address' => $request->student_address,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'student_photo'=>$request->is_student_photo,
            'background_image'=> $background_image,
            'signature' => $signature,
            'logo' => $logo,
        ]);
        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Id Card created successfully',
            ]);
            return response([
                'status' => 'error',
                'status_code' => 400,
                'message' => 'Something went wrong',
            ]);
        }
    }
    public function getIdCardList()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $idCard_list = StudentIdCard::where('school_id', $activeSchool->id)->get();
        if (count($idCard_list) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'idCardList' => IdCardDropdownResource::collection($idCard_list),
            'message' => ''
        ]);
    }
    public function updateData(Request $request, StudentIdCard $studentIdCard)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $background_image = null;
        if ($request->hasFile('background_image') && $request->background_image != '') {
            $background_image = '/storage/' . $request->background_image->store('images/id_cards');
        } else{
            $background_image = $studentIdCard->background_image;
        }
        $signature = null;
        if ($request->hasFile('signature') && $request->signature != '') {
            $signature = '/storage/' . $request->signature->store('images/id_cards');
        } else {
        $signature = $studentIdCard->signature;
        }
        $logo = null;
        if ($request->hasFile('logo') && $request->logo != '') {
            $logo = '/storage/' . $request->logo->store('images/id_cards');
        } else {
            $logo = $studentIdCard->logo;
        }

        $update = $studentIdCard->update([
            'school_id' => $activeSchool->id,
            'school_name' => $request->school_name,
            'id_card_title' => $request->title,
            'header_color' => $request->header_color,
            'address' => $request->address_phone_email,
            'admission_number' => $request->admission_number,
            'student_name' => $request->student_name,
            'class' => $request->class,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'student_address' => $request->student_address,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'student_photo' => $request->is_student_photo,
            'background_image' => $background_image,
            'signature' => $signature,
            'logo' => $logo,
        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Id Card updated successfully',
            ]);
            return response([
                'status' => 'error',
                'status_code' => 400,
                'message' => 'Something went wrong',
            ]);
        }
        }

    // For Generate //
    public function saveData2(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school')->first();
        }
        foreach ($request->admission_ids as $key => $value) {
            $created = GenerateIdCard::create([
                'school_id' => $activeSchool->id,
                'school_class_id' => $request->class_id,
                'school_section_id' => $request->section_id,
                'idCard_id' => $request->card_id,
                'admission_id' => $value,
                'status' => 'activated',
            ]);
            if ($created) {
                return response([
                    'status' => 'success',
                    'status_code' => 201,
                    'message' => 'Generate Id Card created successfully',
                ]);
            }
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
        $idCard_data = StudentIdCard::where('school_id', $activeSchool->id)->allowed()->get();
        if (count($idCard_data) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'show_idCard_list' => IdCardResource::collection($idCard_data),
            'message' => ''
        ]);

        return response([
            'status' => 'warning',
            'status_code' => 300,
            'show_idCard_list' => null,
            'message' => 'No Id Card created yet'
        ]);
    }
    public function getGeneratedIdCards(Admission $admission, StudentIdCard $studentIdCard)
    {

        return response([
            'status' => 'success',
            'status_code' => 200,
            'student' => new StudentAdmissionResource($admission),
            'idCardList' => new IdCardResource($studentIdCard),
            'message' => ''
        ]);
    }
    public function changeStatusData(Request $request, StudentIdCard $studentIdCard)
    {
        $updated = $studentIdCard->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Id Card
            successfully ' . $request->status,
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
