<?php

namespace App\Http\Controllers\School\Examinations;

use App\Http\Controllers\Controller;
use App\Models\ExamSchedule;
use App\Models\AddNewExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\School\Examinations\ExamScheduleResource;
use App\Http\Resources\School\Examinations\ExamNameDropdownResource;
use App\Models\ExamGroup;
use App\Models\User;

class ExamScheduleController extends Controller
{
    public function showData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $examSchedule = ExamSchedule::where('school_id', $activeSchool->id)->with(['schoolClass', 'schoolSection'])->allowed()->get();
        if (count($examSchedule) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'examSchedule_list' => ExamScheduleResource::collection($examSchedule),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'examSchedule_list' => null,
            'message' => 'No Group created yet'
        ]);
    }
    public function getExamName()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $examSchedule = ExamSchedule::where('school_id', $activeSchool->id)->allowed()->get();
        if (count($examSchedule) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'exam_names' => ExamNameDropdownResource::collection($examSchedule),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'exam_names' => null,
            'message' => 'No Group created yet'
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

        $exam_type = ExamSchedule::where('id', $request->id)->first();
        if ($exam_type) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Exam is already exist'
        ]);
        $created = ExamSchedule::create([
            'school_id' => $activeSchool->id,
            'class_id'=>$request->classId,
            'section_id'=>$request->sectionId,
            'exam_name'=>$request->exam_name,
            'exam_date'=>$request->exam_date,
            'exam_time' => $request->exam_time,
            'duration' => $request->exam_duration,
            'subjects' => json_encode($request->subject_ids)
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'exam_schedule' => new ExamScheduleResource($created),
                'message' => 'Exam Schedule created successfully',
            ]);
        }

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Exam',
        ]);
    }
    public function getEditData(ExamSchedule $examSchedule)
    {
        return response([
            'status' => 'success',
            'status_code' => 200,
            'exam_schedule' => new ExamScheduleResource($examSchedule),
            'message' => ''
        ]);
    }
    public function updateData(Request $request, ExamSchedule $examSchedule)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $image = '';
        if ($request->has('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('uploadContent/images');
        }

        $update = $examSchedule->update(['school_id' => $activeSchool->id,
            'class_id' => $request->classId,
            'section_id' => $request->sectionId,
            'exam_name' => $request->exam_name,
            'exam_date' => $request->exam_date,
            'exam_time' => $request->exam_time,
            'duration' => $request->exam_duration,
            'subjects' => json_encode($request->subject_ids)
        ]);

        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Schedule Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Exam Schedule',
        ]);
    }
    public function changeStatusData(Request $request, ExamSchedule $examSchedule)
    {
        if ($request->status == 'deleted') {
            $updated = $examSchedule->update(['status' => $request->status]);
        } else if ($request->status == 'published') {
            $updated = $examSchedule->update(['status' => $request->status, 'published_at' => date('Y-m-d')]);
        } else {
            $updated = $examSchedule->update(['status' => $request->status, 'published_at' => date('Y-m-d')]);
        }
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Exam Schedule successfully ' . $request->status,
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
