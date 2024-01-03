<?php

namespace App\Http\Controllers\School\Academics;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Academics\ClassPeriodResource;
use App\Http\Resources\School\Academics\ClassPeriodsResource;
use App\Http\Resources\School\Academics\ClassPeriodSubjectResource;
use App\Http\Resources\School\Academics\SchoolClassPeriodsResource;
use App\Http\Resources\School\Common\ClassListResource;
use App\Http\Resources\School\Common\SectionListResource;
use App\Models\ClassPeriod;
use App\Models\ClassPeriodSubject;
use App\Models\ClassSectionPeriods;
use App\Models\SchoolClass;
use App\Models\SchoolSection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mockery\Generator\StringManipulation\Pass\ClassPass;

class ClassPeriodsController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $periods = ClassPeriod::where('school_id', $activeSchool->id)->allowed()->get();
        $classes = SchoolClass::where('school_id', $activeSchool->id)->active()->get();
        if ($periods && count($periods) > 0) {
            return response([
                'status' => 'success',
                'message' => '',
                'classes' => ClassListResource::collection($classes),
                'periods' => ClassPeriodResource::collection($periods)
            ]);
        }
        return response([
            'status' => 'error',
            'message' => 'Class or Periods not found',
        ]);
    }
    public function getPeriodData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $periods = ClassSectionPeriods::where('school_id', $activeSchool->id)->where('school_class_id', $request->class)->where('school_section_id', $request->section)->with('period')->get();
        $subjects = ClassPeriodSubject::where('school_id', $activeSchool->id)->where('school_class_id', $request->class)->where('school_section_id', $request->section)->get();

        if ($periods && count($periods) > 0) {
            return response([
                'status' => 'success',
                'message' => '',
                'periods' => ClassPeriodsResource::collection($periods),
                'periods_subjects' => ClassPeriodSubjectResource::collection($subjects),
            ]);
        }
        return response([
            'status' => 'error',
            'message' => 'Class or Periods not found',
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
        $period = ClassPeriod::where('school_id', $activeSchool->id)->where('name', $request->name)->orWhere('start', $request->start)->allowed()->first();
        if ($period) {
            return response([
                'status' => 'warning',
                'message' => 'period is already exist',
            ]);
        } else {
            $created = ClassPeriod::create([
                'school_id' => $activeSchool->id,
                'name' => $request->name,
                'start' => $request->start,
                'end' => $request->end
            ]);
            if ($created) {
                $periodCreated = ClassPeriod::where('id', $created->id)->first();
                return response([
                    'status' => 'success',
                    'message' => 'period created successfully!',
                    'period' => new ClassPeriodResource($periodCreated),
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'Something went wrong, unable to create period'
                ]);
            }
        }
    }
    public function updateData(Request $request, ClassPeriod $classPeriod)
    {
        $updated = $classPeriod->update(['name' => $request->name, 'start' => $request->start, 'end' => $request->end]);
        if ($updated) return response([
            'status' => 'success',
            'message' => 'Update Class Period data successfully ',
        ]);


        return response([
            'status' => 'error',
            'message' => 'Oops!! Something went wrong. Unable to update class period ',
        ]);
    }
    public function changeStatusData(Request $request, ClassPeriod $classPeriod)
    {
        $updated = $classPeriod->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'message' => 'Class Period data successfully ' . $request->status,
        ]);

        if ($request->status == 'activated') $message =
            'activate';
        else if ($request->status == 'deactivated') $message =
            'dectivate';
        else if ($request->status == 'deleted') $message = 'delete';

        return response([
            'status' => 'error',
            'message' => 'Oops!! Something went wrong. Unable to ' . $message,
        ]);
    }

    public function getClassSectionperiods(Request $request)
    {
        if ($request->classId && $request->classId != -1) {
            if ($request->sectionId && $request->sectionId != -1) {
                $classPeriods = ClassSectionPeriods::where('school_section_id', $request->sectionId)->where('school_class_id', $request->classId)->get();
            } else {
                $classPeriods = ClassSectionPeriods::where('school_class_id', $request->classId)->get();
            }
        }
        if ($classPeriods && count($classPeriods) > 0) return response([
            'status' => 'success',
            'school_class_section_periods' => SchoolClassPeriodsResource::collection($classPeriods),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'school_class_section_periods' => null,
            'message' => 'No period selected yet'
        ]);
    }

    public function getSections(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $classSections = SchoolClass::where('school_id', $activeSchool->id)->where('id', $request->classId)->with('schoolSections')->active()->first();
        if ($classSections) return response([
            'status' => 'success',
            'status_code' => 200,
            'school_class_sections' => SectionListResource::collection($classSections->schoolSections),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'school_class_sections' => null,
            'message' => 'No section selected yet'
        ]);
    }
}
