<?php

namespace App\Http\Controllers\School\Examinations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\School\Examinations\AdmitCardResource;
use App\Http\Resources\School\Examinations\ExamNamesDropdownResource;
use App\Http\Resources\School\Examinations\AdmitDropdownResource;
use App\Models\AddNewExam;
use App\Models\AdmitCard;
use Illuminate\Http\Request;

class AdmitCardController extends Controller
{
    public function getExams(){
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $exam_names = AddNewExam::where('school_id', $activeSchool->id)->active()->get();
        if (count($exam_names) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'exam_names_list' => ExamNamesDropdownResource::collection($exam_names),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'exam_names_list' => null,
            'message' => 'No Card created yet'
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
        $background_image = null;
        if ($request->has('background_image') && $request->background_image != '') {
            $background_image = '/storage/' . $request->background_image->store('images/admit_cards');
        }
        $signature = null;
        if ($request->has('signature') && $request->signature != '') {
            $signature = '/storage/' . $request->signature->store('images/admit_cards');
        }
        $left_logo = null;
        if ($request->has('left_logo') && $request->left_logo != '') {
            $left_logo = '/storage/' . $request->left_logo->store('images/admit_cards');
        }
        $right_logo = null;
        if ($request->has('right_logo') && $request->right_logo != '') {
            $right_logo = '/storage/' . $request->right_logo->store('images/admit_cards');
        }
        $created = AdmitCard::create([
            'school_id' => $activeSchool->id,
            'exam_id' => $request->exam_name,
            'template' => $request->template,
            'heading' => $request->heading,
            'title' => $request->title,
            'school_name' => $request->school_name,
            'exam_center' => $request->exam_center,
            'footer_text' => $request->footer_text,
            'student_name' => $request->student_name,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'date_of_birth' => $request->date_of_birth,
            'admission_number' => $request->admission_number,
            'roll_no' => $request->roll_number,
            'student_address' => $request->student_address,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'class' => $request->class,
            'section' => $request->section,
            'background_image' => $background_image,
            'signature' => $signature,
            'left_logo' => $left_logo,
            'right_logo' => $right_logo,
        ]);
        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Admit Card created successfully',
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

        $admit_card = AdmitCard::where('school_id', $activeSchool->id)->active()->get();
        if (count($admit_card) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'admit_card_list' => AdmitCardResource::collection($admit_card),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'admit_card_list' => null,
            'message' => 'No Card created yet'
        ]);
    }

    public function updateData(Request $request, AdmitCard $admitCard)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $background_image = null;
        if ($request->has('background_image') && $request->background_image != '') {
            $background_image = '/storage/' . $request->background_image->store('images/admit_cards');
        }
        $signature = null;
        if ($request->has('signature') && $request->signature != '') {
            $signature = '/storage/' . $request->signature->store('images/admit_cards');
        }
        $left_logo = null;
        if ($request->has('left_logo') && $request->left_logo != '') {
            $left_logo = '/storage/' . $request->left_logo->store('images/admit_cards');
        }
        $right_logo = null;
        if ($request->has('right_logo') && $request->right_logo != '') {
            $right_logo = '/storage/' . $request->right_logo->store('images/admit_cards');
        }

        $update = $admitCard->update([
            'school_id' => $activeSchool->id,
            'template' => $request->template,
            'heading' => $request->heading,
            'title' => $request->title,
            'exam_name' => $request->exam_name,
            'school_name' => $request->school_name,
            'exam_center' => $request->exam_center,
            'footer_text' => $request->footer_text,
            'student_name' => $request->student_name,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'date_of_birth' => $request->date_of_birth,
            'admission_number' => $request->admission_number,
            'roll_no' => $request->roll_number,
            'student_address' => $request->student_address,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'class' => $request->class,
            'section' => $request->section,
            'background_image' => $background_image,
            'signature' => $signature,
            'left_logo' => $left_logo,
            'right_logo' => $right_logo,
        ]);

        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Admit Card Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Admit Card',
        ]);
    }
    public function changeStatusData(Request $request, AdmitCard $admitCard)
    {
        if ($request->status == 'deleted') {
            $updated = $admitCard->update(['status' => $request->status]);
        } else if ($request->status == 'published') {
            $updated = $admitCard->update(['status' => $request->status, 'published_at' => date('Y-m-d')]);
        } else {
            $updated = $admitCard->update(['status' => $request->status, 'published_at' => date('Y-m-d')]);
        }
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Admit Card successfully ' . $request->status,
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
