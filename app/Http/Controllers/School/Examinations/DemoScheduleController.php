<?php

namespace App\Http\Controllers\School\Examinations;

use App\Models\AddNewExam;
use App\Models\ExamGroup;
use App\Http\Resources\School\Examinations\ExamNameDropdownResource;
use App\Http\Resources\School\Examinations\AddExamSubjectResource;
use App\Http\Controllers\Controller;
use App\Models\AddExamSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class DemoScheduleController extends Controller
{
    public function getExams(ExamGroup $examGroup)
    {
        $examNames = AddNewExam::where('exam_group_id', $examGroup->id)->allowed()->get();
        if (count($examNames) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'exam_names' => ExamNameDropdownResource::collection($examNames),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'exam_names' => null,
            'message' => 'No Group created yet'
        ]);
    }
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $exam_scheduleList = AddExamSubject::where('school_id', $activeSchool->id)->allowed()->get();
        if (count($exam_scheduleList) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'examSchedule_list' => AddExamSubjectResource::collection($exam_scheduleList),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'examSchedule_list' => null,
            'message' => 'No Group created yet'
        ]);
    }
}
