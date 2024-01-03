<?php

namespace App\Http\Controllers\School\Examinations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\ExamType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\School\Examinations\ExamGroupResource;
use App\Http\Resources\School\Examinations\ExamGroupDropdownResource;
use App\Http\Resources\School\Examinations\ExamTypeDropdownResource;
use App\Models\ExamGroup;

class ExamGroupController extends Controller
{
    public function getExamType()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $examTypes = ExamType::where('school_id', $activeSchool->id)->active()->get();
        if (count($examTypes) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'examType_list' => ExamTypeDropdownResource::collection($examTypes),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'examType_list' => null,
            'message' => 'No Exam created yet'
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

        $examGroups = ExamGroup::where('school_id', $activeSchool->id)->active()->get();
        if (count($examGroups) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'examGroups' =>ExamGroupDropdownResource::collection($examGroups),
            'examGroup_list' => ExamGroupResource::collection($examGroups),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'examGroup_list' => null,
            'message' => 'No Group created yet'
        ]);
    }
    public function getExamGroupList()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $examGroups = ExamGroup::where('school_id', $activeSchool->id)->active()->get();
        if (count($examGroups) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'examGroup_list' => ExamGroupDropdownResource::collection($examGroups),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'examGroup_list' => null,
            'message' => 'No Exam created yet'
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

        $exam_group = ExamGroup::where('id', $request->id)->first();
        if ($exam_group) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Group is already exist'
        ]);
        $created = ExamGroup::create([
            'school_id' => $activeSchool->id,
            'class_id' => $request->classId,
            'group_name' => $request->group_name,
            'exam_type' => $request->exam_type,
            'description' => $request->exam_description,
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'exam_groups' => new ExamGroupResource($created),
                'message' => 'Exam Group created successfully',
            ]);
        }

        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create Group',
        ]);
    }
    public function updateData(Request $request, ExamGroup $examGroup)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $update = $examGroup->update([
            'school_id' => $activeSchool->id,
            'class_id' => $request->classId,
            'group_name' => $request->group_name,
            'exam_type' => $request->exam_type,
            'description' => $request->exam_description,

        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Exam Group Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update Exam Group',
        ]);
    }
    public function changeStatusData(Request $request, ExamGroup $examGroup)
    {
        $updated = $examGroup->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Exam successfully ' . $request->status,
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
