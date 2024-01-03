<?php

namespace App\Http\Controllers\School\Common;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Academics\SchoolSectionResource;
use App\Http\Resources\School\Common\AssignedSubjectListResource;
use App\Http\Resources\School\Common\ClassListResource;
use App\Http\Resources\School\Common\SectionListResource;
use App\Http\Resources\School\Common\SessionResource;
use App\Http\Resources\School\Common\SubjectListResource;
use App\Http\Resources\Admin\Assign\AssignResource;
use App\Http\Resources\Admin\Categories\CategoryResource;
use App\Http\Resources\Admin\School\SchoolResource;
use App\Http\Resources\School\Human_Resource\DepartmentDropDownResource;
use App\Models\ClassSectionSubject;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\School;
use App\Models\SchoolSession;
use App\Models\Subject;
use App\Models\User;
use App\Models\Category;
use App\Models\AssignModule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class GeneralController extends Controller
{
    public function getSchoolClasses()
    {
        $activeSchoolId = -1;
        if (Session::has('active_school_id')) {
            $activeSchoolId = Session::get('active_school_id');
        }
        $authUser = Auth::user();
        $schoolClasses = SchoolClass::with('schoolSections')->where('school_id', $activeSchoolId)->active()->get();
        if ($schoolClasses) return response(['status' => 'success', 'status_code' => '200', 'message' => '', 'class_list' => ClassListResource::collection($schoolClasses)]);
        return response(['status' => 'error', 'status_code' => '400', 'message' => 'No class data found', 'class_list' => null]);
    }

    public function getSchoolClassSections(SchoolClass $schoolClass)
    {
        $activeSchoolId = -1;
        if (Session::has('active_school_id')) {
            $activeSchoolId = Session::get('active_school_id');
        }
        $authUser = Auth::user();
        $schoolClass = SchoolClass::where('id', $schoolClass->id)->with(['schoolSections' => function ($query) {
            return $query->active();
        }])->first();
        if ($schoolClass->schoolSections && count($schoolClass->schoolSections) > 0)
            return response(['status' => 'success', 'status_code' => '200', 'message' => '', 'section_list' => SectionListResource::collection($schoolClass->schoolSections)]);
        return response(['status' => 'error', 'status_code' => '400', 'message' => 'No Section data found', 'section_list' => null]);
    }

    public function getSession(SchoolSession $schoolSession)
    {
        $activeSchoolId = -1;
        if (Session::has('active_school_id')) {
            $activeSchoolId = Session::get('active_school_id');
            $schoolSession = SchoolSession::where('school_id', $activeSchoolId)->active()->get();
            if (count($schoolSession) > 0) return response([
                'status' => 'success',
                'status_code' => 200,
                'school_sessions' => SessionResource::collection($schoolSession),
                'message' => ''
            ]);
            return response([
                'status' => 'warning',
                'status_code' => 300,
                'school_sessions' => null,
                'message' => 'No Session created yet'
            ]);
        }
    }
    public function getSchools()
    {
        $activeSchoolId = -1;
        if (Session::has('active_school_id')) {
            $activeSchoolId = Session::get('active_school_id');
        }
        $authUser = Auth::user();
        // $user = User::where('id', $authUser->id)->with(['schools' => function ($query) {
        //     return $query->with('schoolGroup');
        // }])->first();

        $user = User::where('id', $authUser->id)->first();
        $activeSchool = School::where('user_id',$user->id)->first();

        if ($activeSchool) {
            Session::put('active_school', $activeSchool);
        }
        // $schoolGroup = $user->schools->first()->schoolGroup;
        if ($activeSchool) return response([
            'status' => 'success', 'status_code' => '200', 'message' => '', 'active_school' =>new SchoolResource($activeSchool),
             'active_school_id' => $activeSchoolId
        ]);
        return  response(['status' => 'error', 'status_code' => '400', 'message' => 'No school data found', 'schools' => null, 'active_school_id' => $activeSchoolId]);
    }

    public function setActiveSchool(Request $request)
    {
        Session::put('active_school_id', $request->school_id);
        $activeSchoolId = -1;
        if (Session::has('active_school_id')) {
            $activeSchoolId = Session::get('active_school_id');
        }
        $school = School::find($activeSchoolId);
        return response(['status' => 'success',
        'school' => $school,
        'active_school_id' => $activeSchoolId]);
    }
    public function addActivation(Request $request)
    {
        $activation_startDate = Carbon::now();
        $activation_expiryDate = $activation_startDate->addYear();
        $school = School::where('id',$request->active_school_id)->where('activation_key',$request->activation_key)->first();

        if(!$school) return response([
            'status' => 'warning',
            'message' => 'Invalid Activation Key'
        ]);
        $update = $school->update([
            'user_id' => $school->user_id,
            'school_group_id' => $school->school_group_id,
            'name' => $school->name,
            'contact_person_name' => $school->contact_person_name,
            'mobile' => $school->mobile,
            'alternative_mobile' => $school->alternative_mobile,
            'email' => $school->email,
            'password' => $school->password,
            'alternative_email' => $school->alternative_email,
            'password' => Hash::make($school->password),
            'password_text' => $school->password_text,
            'current_address_line1' =>  $school->current_address_line1,
            'current_address_line2' => $school->current_address_line2,
            'current_location' => $school->current_location,
            'current_landmark' => $school->current_landmark,
            'current_city' => $school->current_city,
            'current_pincode' => $school->current_pincode,
            'current_state' => $school->current_state,
            'current_country' => $school->current_country,
            'is_same_address' => $school->is_same_address,
            'permanent_address_line1' =>  $school->permanent_address_line1,
            'permanent_address_line2' => $school->permanent_address_line2,
            'permanent_location' => $school->permanent_location,
            'permanent_landmark' => $school->permanent_landmark,
            'permanent_city' => $school->permanent_city,
            'permanent_pincode' => $school->permanent_pincode,
            'permanent_state' => $school->permanent_state,
            'permanent_country' => $school->permanent_country,
            'activation_key' => $school->activation_key,
            'activation_start_date' => Carbon::now(),
            'activation_end_date' => $activation_expiryDate,
            'status' => 'activated'
        ]);

        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Activation Success',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create school',
        ]);
    }
    public function getMenus(School $school)
    {
        $auth = Auth::user();
        $user = User::find($auth->id);
        $school_id =School::where('user_id',$user->id)->first();
        $menus = AssignModule::where('school_id', $school_id->id)->first();
        $menu_ids = json_decode($menus->name);
        $menu_ids = explode(',', $menu_ids[0]);
        $module_names = Category::whereIn('id', $menu_ids)->get();
        if ($menus) return response([
            's        tatus_code' => 200,
            'status' => 'success',
            'menu_ids' => new AssignResource($menus),
            'menu_names' => CategoryResource::collection($module_names),
        ]);
        return response([
            'status_code' => 300,
            'status' => 'warning',
            'menus' => null,
            'message' => 'No category created yet',
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

    public function getSchoolSubjects(Request $request)
    {
        $activeSchoolId = -1;
        if (Session::has('active_school_id')) {
            $activeSchoolId = Session::get('active_school_id');
        }
        if ($request->has('class_id') && $request->class_id != "-1") {
            if ($request->has('section_id') && $request->section_id != "-1") {
                $subjects = ClassSectionSubject::where('school_class_id', $request->class_id)->where('school_section_id', $request->section_id)->with('subject')->get();
            } else {
                $subjects = ClassSectionSubject::select('subject_id')->distinct()->where('school_class_id', $request->class_id)->with('subject')->get();
            }
            $subjectList = AssignedSubjectListResource::collection($subjects);
        } else {
            $subjects = Subject::where('school_id', $activeSchoolId)->get();
            $subjectList = SubjectListResource::collection($subjects);
        }
        return response([
            'status' => 'success',
            'message' => '',
            'subject_list' => $subjectList
        ]);
    }
    public function getSchoolDepartments()
    {
        $activeSchoolId = -1;
        if (Session::has('active_school_id')) {
            $activeSchoolId = Session::get('active_school_id');
        }
        $departments = Department::where('school_id', $activeSchoolId)->allowed()->get();
        if ($departments && count($departments) > 0) return response(['status' => 'success', 'status_code' => '200', 'message' => '', 'department_list' => DepartmentDropDownResource::collection($departments)]);
        return response(['status' => 'error', 'status_code' => '400', 'message' => 'No department data found', 'department_list' => null]);
    }
}
