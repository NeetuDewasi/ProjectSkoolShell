<?php

namespace App\Http\Controllers\School\Academics;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Academics\SubjectResource;
use App\Http\Resources\School\Examinations\SubjectDropdownResource;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SchoolSubjectController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $schoolSubjects = Subject::where('school_id', $activeSchool->id)->active()->get();
        if (count($schoolSubjects) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'school_subjects' => SubjectResource::collection($schoolSubjects),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'school_subjects' => null,
            'message' => 'No subject created yet'
        ]);
    }

    public function getSubjects()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $schoolSubjects = Subject::where('school_id', $activeSchool->id)->active()->get();
        if (count($schoolSubjects) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'school_subjects' => SubjectDropdownResource::collection($schoolSubjects),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'school_subjects' => null,
            'message' => 'No subject created yet'
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
        $schoolSubject = Subject::where('name', $request->name)->where('school_id', $activeSchool->id)->allowed()->first();

        if ($schoolSubject) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This subject is already exist'
        ]);

        $created = Subject::create([
            'school_id' => $activeSchool->id,
            'name' => $request->name,
            'subject_code' => $request->subject_code,
            'subject_type' => $request->subject_type,
        ]);

        if ($created) {
            $subject = Subject::where('id', $created->id)->first();
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'subject created successfully',
                'school_subject' => new SubjectResource($subject),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create subject',
        ]);
    }

    public function changeStatusData(Request $request, Subject $subject)
    {
        $updated = $subject->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Subject data successfully ' . $request->status,
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

    public function updateData(Request $request, Subject $subject)
    {
        $update = $subject->update([
            'name' => $request->name,
            'subject_code' => $request->subject_code,
            'subject_type' => $request->subject_type,
        ]);

        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'subjects Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update school subject',
        ]);
    }
}
