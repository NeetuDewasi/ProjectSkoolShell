<?php

namespace App\Http\Controllers\School\Examinations;

use App\Http\Controllers\Controller;
use App\Models\DesignMarksheet;
use App\Models\Admission;
use App\Http\Resources\School\Examinations\DesignMarksheetResource;
use App\Http\Resources\School\Examinations\AssignMarksResource;
use App\Http\Resources\School\Examinations\DesignMarksheetDropdownResource;
use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Models\AssignExamMark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class DesignMarksheetController extends Controller
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
            $background_image = '/storage/' . $request->background_image->store('images/design_marksheet');
        }

        $left_logo = null;
        if ($request->has('left_logo') && $request->left_logo != '') {
            $left_logo = '/storage/' . $request->left_logo->store('images/design_marksheet');
        }
        $right_logo = null;
        if ($request->has('right_logo') && $request->right_logo != '') {
            $right_logo = '/storage/' . $request->right_logo->store('images/design_marksheet');
        }
        $left_sign = null;
        if ($request->has('left_sign') && $request->left_sign != '') {
            $left_sign = '/storage/' . $request->left_sign->store('images/design_marksheet');
        }
        $middle_sign = null;
        if ($request->has('middle_sign') && $request->middle_sign != '') {
            $middle_sign = '/storage/' . $request->middle_sign->store('images/design_marksheet');
        }
        $right_sign = null;
        if ($request->has('right_sign') && $request->right_sign != '') {
            $right_sign = '/storage/' . $request->right_sign->store('images/design_marksheet');
        }
        $created = DesignMarksheet::create([
            'school_id' => $activeSchool->id,
            'exam_id' => $request->exam_name,
            'template' => $request->template,
            'heading' => $request->heading,
            'title' => $request->title,
            'school_name' => $request->school_name,
            'exam_center' => $request->exam_center,
            'body_text' => $request->body_text,
            'footer_text' => $request->footer_text,
            'printing_date' => $request->printing_date,
            'student_name' => $request->student_name,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'exam_session' => $request->exam_session,
            'date_of_birth' => $request->date_of_birth,
            'admission_number' => $request->admission_number,
            'division' => $request->division,
            'roll_no' => $request->roll_number,
            'photo' => $request->student_photo,
            'class' => $request->class,
            'section' => $request->section,
            'remark' => $request->remark,
            'background_image' => $background_image,
            'left_logo' => $left_logo,
            'right_logo' => $right_logo,
            'left_sign' => $left_sign,
            'middle_sign' => $middle_sign,
            'right_sign' => $right_sign,
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

        $design_marksheet = DesignMarksheet::where('school_id', $activeSchool->id)->active()->get();
        if (count($design_marksheet) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'design_marksheet_list' => DesignMarksheetResource::collection($design_marksheet),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'design_marksheet_list' => null,
            'message' => 'No marksheet created yet'
        ]);
    }
    public function getMarks(Request $request){
        $total = 0;
        $marks_details = AssignExamMark::where('examgroup_id', $request->exam_group_id)->where('exam_id', $request->exam_id)->where('admission_id', $request->admission_id)->active()->get();
        $total = $marks_details->sum('obtained_marks');
        $totalSubject= 0;
        if ($marks_details) return response([
            'status' => 'success',
            'status_code' => 200,
            'marks_details' =>AssignMarksResource::collection($marks_details),
            'total' => $total,
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'marks_details' => null,
            'message' => 'No Marksheet created yet'
        ]);
    }
    public function updateData(Request $request, DesignMarksheet $designMarksheet)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $background_image = null;
        if ($request->has('background_image') && $request->background_image != '') {
            $background_image = '/storage/' . $request->background_image->store('images/design_marksheet');
        }

        $left_logo = null;
        if ($request->has('left_logo') && $request->left_logo != '') {
            $left_logo = '/storage/' . $request->left_logo->store('images/design_marksheet');
        }
        $right_logo = null;
        if ($request->has('right_logo') && $request->right_logo != '') {
            $right_logo = '/storage/' . $request->right_logo->store('images/design_marksheet');
        }
        $left_sign = null;
        if ($request->has('left_sign') && $request->left_sign != '') {
            $left_sign = '/storage/' . $request->left_sign->store('images/design_marksheet');
        }
        $middle_sign = null;
        if ($request->has('middle_sign') && $request->middle_sign != '') {
            $middle_sign = '/storage/' . $request->middle_sign->store('images/design_marksheet');
        }
        $right_sign = null;
        if ($request->has('right_sign') && $request->right_sign != '') {
            $right_sign = '/storage/' . $request->right_sign->store('images/design_marksheet');
        }
        $update = $designMarksheet->update([
            'school_id' => $activeSchool->id,
            'exam_id' => $request->exam_name,
            'template' => $request->template,
            'heading' => $request->heading,
            'title' => $request->title,
            'school_name' => $request->school_name,
            'exam_center' => $request->exam_center,
            'body_text' => $request->body_text,
            'footer_text' => $request->footer_text,
            'printing_date' => $request->printing_date,
            'student_name' => $request->student_name,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'exam_session' => $request->exam_session,
            'date_of_birth' => $request->date_of_birth,
            'admission_number' => $request->admission_number,
            'division' => $request->division,
            'roll_no' => $request->roll_number,
            'photo' => $request->student_photo,
            'class' => $request->class,
            'section' => $request->section,
            'remark' => $request->remark,
            'background_image' => $background_image,
            'left_logo' => $left_logo,
            'right_logo' => $right_logo,
            'left_sign' => $left_sign,
            'middle_sign' => $middle_sign,
            'right_sign' => $right_sign,
        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Marksheet Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Admit Card',
        ]);
    }
    public function getTemplateList()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $marksheet_list = DesignMarksheet::where('school_id', $activeSchool->id)->active()->get();
        if (count($marksheet_list) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'marksheet_list' => DesignMarksheetDropdownResource::collection($marksheet_list),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'marksheet_list' => null,
            'message' => 'No Marksheet created yet'
        ]);
    }
    public function changeStatusData(Request $request, DesignMarksheet $designMarksheet)
    {
        if ($request->status == 'deleted') {
            $updated = $designMarksheet->update(['status' => $request->status]);
        }
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Marksheet successfully ' . $request->status,
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
    public function getGeneratedMarksheet(Admission $admission, DesignMarksheet $designMarksheet)
    {

        return response([
            'status' => 'success',
            'status_code' => 200,
            'student' => new StudentAdmissionResource($admission),
            'marksheetList' => new DesignMarksheetResource($designMarksheet),
            'message' => ''
        ]);
    }
}
