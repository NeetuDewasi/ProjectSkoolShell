<?php

namespace App\Http\Controllers\School\Academics;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Academics\SchoolClassResource;
use App\Http\Resources\School\Academics\SchoolSectionResource;
use App\Http\Resources\School\Common\ClassListResource;
use App\Models\SchoolClass;
use App\Models\SchoolSection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SchoolClassController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $schoolClasses = SchoolClass::where('school_id', $activeSchool->id)->active()->get();
        if (count($schoolClasses) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'school_classes' => SchoolClassResource::collection($schoolClasses),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'school_classes' => null,
            'message' => 'No class created yet'
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
        $schoolClass = SchoolClass::where('number', $request->number)->where('school_id', $activeSchool->id)->allowed()->first();

        if ($schoolClass) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This class is already exist'
        ]);

        $created = SchoolClass::create([
            'school_id' => $activeSchool->id,
            'name' => "Class " . $request->number,
            'number' => $request->number,
        ]);
        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'class created successfully',
                'school_class' => new SchoolClassResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create class',
        ]);
    }

    public function updateData(Request $request, SchoolClass $schoolClass)
    {
        $update = $schoolClass->update([
            'name' => "Class" . $request->number,
            'number' => $request->number,
        ]);

        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'classes  Updated Successfully',
                'school_class' => new SchoolClassResource($update),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update school class',
        ]);
    }

    public function changeStatusData(Request $request, SchoolClass $schoolClass)
    {
        $updated = $schoolClass->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Class data successfully ' . $request->status,
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
    public function getClassSections()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $classes = SchoolClass::where('school_id', $activeSchool->id)->active()->get();
        $sections = SchoolSection::where('school_id', $activeSchool->id)->active()->get();
        if (count($sections) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'school_sections' => SchoolSectionResource::collection($sections),
            'school_classes' => ClassListResource::collection($classes),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'school_sections' => null,
            'message' => 'No class created yet'
        ]);
    }
    public function getClassSection(SchoolClass $schoolClass)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $classSections = SchoolClass::where('id', $schoolClass->id)->with('schoolSections')->active()->first();
        if ($classSections) return response([
            'status' => 'success',
            'status_code' => 200,
            'school_class_sections' => SchoolSectionResource::collection($classSections->schoolSections),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'school_class_sections' => null,
            'message' => 'No section selected yet'
        ]);
    }

    public function assignClassSections(Request $request, SchoolClass $schoolClass)
    {
        $schoolClass->schoolSections()->sync(explode(",", $request->section_ids));

        return response(([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'class sections update successfully!'
        ]));
    }
}
