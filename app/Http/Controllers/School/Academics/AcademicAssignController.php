<?php

namespace App\Http\Controllers\School\Academics;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Academics\AssignSubjectTeacherResource;
use App\Http\Resources\School\Academics\ClassperiodResource;
use App\Http\Resources\School\Academics\PeriodSubjectsResource;
use App\Http\Resources\School\Academics\SchoolClassSubjectResource;
use App\Http\Resources\School\Academics\SchoolSectionResource;
use App\Http\Resources\School\Academics\SubjectResource;
use App\Http\Resources\School\Academics\ClassPeriodSubjectResource;
use App\Http\Resources\School\Academics\ClassPeriodSubjectTeacherRescource;
use App\Http\Resources\School\Common\ClassListResource;
use App\Http\Resources\School\Common\SectionListResource;
use App\Models\ClassPeriod;
use App\Models\ClassPeriodSubject;
use App\Models\ClassSectionPeriods;
use App\Models\ClassSectionSubject;
use App\Models\Employee;
use App\Models\SchoolClass;
use App\Models\SchoolSection;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AcademicAssignController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $classes = SchoolClass::where('school_id', $activeSchool->id)->active()->get();
        $periods = ClassPeriod::get();
        if (count($classes) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'school_classes' => ClassListResource::collection($classes),
            'periods' => ClassPeriodResource::collection($periods),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'school_sections' => null,
            'message' => 'No class created yet'
        ]);
    }
    public function getClassSubject()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $classes = SchoolClass::where('school_id', $activeSchool->id)->active()->get();
        $subjects = Subject::where('school_id', $activeSchool->id)->allowed()->active()->get();
        if (count($classes) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'subjects' => SubjectResource::collection($subjects),
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

    public function getClassSections(SchoolClass $schoolClass)
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

    public function getClassSectionSubjects(Request $request)
    {
        if ($request->has('class') && $request->class != '-1' && $request->class != '') {
            if ($request->has('section') && $request->section != '-1' && $request->section != '') {
                $classSubjects = ClassSectionSubject::where('school_section_id', $request->section)->where('school_class_id', $request->class)->with('subject')->active()->get();
                $assignSubjects = ClassPeriodSubject::where('school_section_id', $request->section)->where('school_class_id', $request->class)->with('subject')->get();
            } else {
                $classSubjects = ClassSectionSubject::where('school_class_id', $request->class)->with('subject')->active()->get();
            }
        }

        if (!$assignSubjects) {
            $subjects = null;
        } else {
            $subjects = $assignSubjects;
        }
        if ($classSubjects) return response([
            'status' => 'success',
            'status_code' => 200,
            'school_class_section_subjects' => SchoolClassSubjectResource::collection($classSubjects),
            'assign_subjects' => PeriodSubjectsResource::collection($subjects),
            'assign_teachers' => AssignSubjectTeacherResource::collection($subjects),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'school_class_section_subjects' => null,
            'message' => 'No section selected yet'
        ]);
    }
    public function assignSubject(Request $request, SchoolClass $schoolClass, SchoolSection $schoolSection)
    {
        $alreadyExist = ClassSectionSubject::where('school_class_id', $schoolClass->id)->where('school_section_id', $schoolSection->id)->with('subject')->active()->get();
        foreach ($alreadyExist as $key => $exist) {
            $deleted = $exist->delete();
        }
        foreach ($request->subject_ids as $value) {
            $newSubjectValue = explode(",", $value);
            foreach ($newSubjectValue  as $subject_id) {
                $created = ClassSectionSubject::create([
                    'school_class_id' => $schoolClass->id,
                    'school_section_id' => $schoolSection->id,
                    'subject_id' => $subject_id,
                ]);
            }
        }
        if ($created) {
            return response([
                'status' => 'success',
                'message' => 'subject assign update successfully',
                'status_code' => 201
            ]);
        } else {
            return response(([
                'status' => 'error',
                'message' => 'something is wrong ! please try again',
                'status_code' => 501
            ]));
        }
    }

    public function assignClassPeriodSubject(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $alreadyExist = ClassPeriodSubject::where('school_class_id', $request->class)->where('school_section_id', $request->section)->get();
        foreach ($alreadyExist as $key => $value) {
            $deleted = $value->delete();
        }
        
        foreach ($request->days as $keyDay => $day) {
            foreach ($request->periods as $key => $value) {
                $subjectList = json_decode($request->subject_list);
                $subject =  $subjectList[$keyDay][$key];
                $subjectId = null;
                if ($subject) {
                    $subject = (object) $subject;
                    $subjectId = $subject->subject_id;
                }

                $created = ClassPeriodSubject::create([
                    'school_id' => $activeSchool->id,
                    'school_class_id' => $request->class,
                    'school_section_id' => $request->section,
                    'class_period_id' => $value,
                    'subject_id' => $subjectId,
                    'employee_id' => $request->teacher_list != null ? json_decode($request->teacher_list)[$keyDay][$key] : null,
                    'day' => $day,
                ]);
            }
        }
        return response([
            'status' => 'success',
            'message' => 'assign subject teacher update successfully',
        ]);
    }

    public function assignPeriod(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        if ($request->has('class')) {
            if ($request->has('section') && $request->section != '-1') {
                $alreadyExist = ClassSectionPeriods::where('school_class_id', $request->class)->where('school_section_id', $request->section)->active()->get();
                foreach ($alreadyExist as $key => $exist) {
                    $deleted = $exist->delete();
                }
            } else {
                $alreadyExist = ClassSectionPeriods::where('school_class_id', $request->class)->active()->get();
                foreach ($alreadyExist as $key => $exist) {
                    $deleted = $exist->delete();
                }
            }
        }
        $created = '';
        if ($request->has('period_ids') && count($request->period_ids) > 0 && $request->period_ids != '') {
            foreach ($request->period_ids as $value) {
                $newSubjectValue = explode(",", $value);
                if ($value != '') {
                    foreach ($newSubjectValue  as $period_id) {
                        $created = ClassSectionPeriods::create([
                            'school_id' => $activeSchool->id,
                            'school_class_id' => $request->class,
                            'school_section_id' => $request->section != "-1" ? $request->section : null,
                            'class_period_id' => $period_id,
                        ]);
                    }
                }
            }
        }
        if ($created || $deleted) {
            return response([
                'status' => 'success',
                'message' => 'period assign update successfully',
            ]);
        } else {
            return response(([
                'status' => 'error',
                'message' => 'samething is wrong ! pleace try agine',
            ]));
        }
    }
    public function getTeacherTimeTable(Request $request)
    {
        $teacher_timeTable = ClassPeriodSubject::where('employee_id', $request->employee_id)->get();
        if(count($teacher_timeTable) > 0) return response([
            'status' => 'success',
            'status_code'=> 200,
            'teacher_timeTable'=> ClassPeriodSubjectTeacherRescource::collection($teacher_timeTable),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'teacher_timeTable' => null,
        ]);
    }
}
