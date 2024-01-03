<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\DownloadCenter\DownloadContentStudentResource;
use App\Http\Resources\school\student\CategoryListresource;
use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Http\Resources\School\Student\StudentListDropdownResource;
use App\Http\Resources\School\Student\HouseDropdownResource;
use App\Models\Admission;
use App\Models\SchoolClass;
use App\Models\SchoolSection;
use App\Models\StudentCategory;
use App\Models\StudentHouse;
use App\Models\StudentSibling;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StudentAdmissionController extends Controller
{
    public function getEditItemData(Admission $admission)
    {
        return response([
            'status' => 'success',
            'status_code' => 200,
            'student_admission' => new StudentAdmissionResource($admission),
            'message' => ''
        ]);
    }
    public function getClassStudentData(Request $request)
    {
        $studentAdmissions = array();
        if ($request->has('class_id') && $request->class_id != '-1') {
            if ($request->has('section_id') && $request->section_id != '-1') {
                $studentAdmissions = Admission::where('school_class_id', $request->class_id)->where('school_section_id', $request->section_id)->get();

            } else {
                $studentAdmissions = Admission::where('school_class_id', $request->class_id)->get();
            }
        } else {
            return response([
                'status' => 'warning',
                'status_code' => 300,
                'student_admissions' => null,
                'message' => 'No admission created yet'
            ]);
        }
        if (count($studentAdmissions) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'students'=> StudentAdmissionResource::collection($studentAdmissions),
            'student_admissions' => DownloadContentStudentResource::collection($studentAdmissions),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_admissions' => null,
            'message' => 'No admission created yet'
        ]);
    }
    public function getData2(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $studentAdmissions = array();

            if ($request->class_id && $request->class_id != null && $request->class_id != '') {
            if
                ($request->section_id && $request->section_id != null && $request->section_id != ''){

                $studentAdmissions = Admission::where('school_class_id', $request->class_id)->where('school_section_id', $request->section_id)->with(['schoolClass', 'schoolSection'])->allowed()->get();
            }
        }
         else {
            return response([
                'status' => 'warning',
                'status_code' => 300,
                'student_details' => null,
                'message' => 'No admission created yet'
            ]);
        }

        if (count($studentAdmissions) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'student_details' => StudentAdmissionResource::collection($studentAdmissions),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_admissions' => null,
            'message' => 'No admission created yet'
        ]);
    }
    public function getDataCertificate(SchoolClass $schoolClass, SchoolSection $schoolSection)
    {
        $studentAdmissions = Admission::where('school_class_id', $schoolClass->id)->where('school_section_id', $schoolSection->id)->allowed()->get();

        if (count($studentAdmissions) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'student_admissions' => StudentAdmissionResource::collection($studentAdmissions),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_admissions' => null,
            'message' => 'No admission created yet'
        ]);
    }

    public function getHouseList()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $studentHouses = StudentHouse::where('school_id', $activeSchool->id)->active()->get();

        if ($studentHouses && count($studentHouses) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'house_list' => HouseDropdownResource::collection($studentHouses),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'house_list' => null,
            'message' => 'No House added yet..',
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
        $studentAdmission = Admission::where('admission_number', $request->admission_number)->first();

        if ($studentAdmission) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This admission is already exist'
        ]);

        $image = '';
        if ($request->has('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('students/images');
        }

        $created = Admission::create([
            'school_id' => $activeSchool->id,
            'admission_number' => $request->admission_number,
            'roll_number' => $request->roll_number,
            'admission_date' => date_format(date_create($request->admission_date), 'Y-m-d'),
            'school_class_id' => $request->class,
            'school_section_id' => $request->section,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'date_of_birth' => date_format(date_create($request->date_of_birth), 'Y-m-d'),
            'gender' => $request->gender,
            'student_category_id' => $request->category,
            'student_house_id' => $request->house,
            'religion' => $request->religion,
            'cast' => $request->caste,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'student_photo' => $image,
            'blood_group' => $request->blood_group,
            'height' => $request->height,
            'weight' => $request->weight,
        ]);

        if ($request->admission_ids && $request->admission_ids != null) {

            foreach ($request->admission_ids as $key => $siblingId) {
                if ($siblingId != '-1') {
                    $sibling = Admission::where('id', $siblingId)->first();
                    if ($sibling->gender === 'male') {
                        $relation = 'brother';
                    } else if ($sibling->gender === 'female') {
                        $relation = 'sister';
                    }
                    $createSibling = StudentSibling::create([
                        'student_id' => $created->id,
                        'sibling_id' => $siblingId,
                        'relation' => $relation
                    ]);
                    $sibling = Admission::where('id', $created->id)->first();
                    if ($sibling->gender === 'male') {
                        $relation = 'brother';
                    } else if ($sibling->gender === 'female') {
                        $relation = 'sister';
                    }
                    $siblingCreate = StudentSibling::create([
                        'student_id' => $siblingId,
                        'sibling_id' => $created->id,
                        'relation' => $relation
                    ]);
                }
            }
        }

        if ($created) {
            $student_admissions = Admission::where('id', $created->id)->first();
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'student detail created successfully',
                'student_admission_id' => $student_admissions->id
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create admission',
        ]);
    }

    public function getStudents(SchoolClass $schoolClass, SchoolSection $schoolSection)
    {
        $students = Admission::where('school_class_id', $schoolClass->id)->where('school_section_id', $schoolSection->id)->get();
        if (count($students) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'student_admission' => StudentListDropdownResource::collection($students),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_admission' => null,
            'message' => 'No admission created yet'
        ]);
    }

    public function getStudentData()
    {
        $studentAdmissions = Admission::allowed()->get();

        if (count($studentAdmissions) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'student_admissions' => StudentAdmissionResource::collection($studentAdmissions),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_admissions' => null,
            'message' => 'No admission created yet'
        ]);
    }
    public function updateData(Request $request, Admission $admission)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        if ($admission->school_id != $activeSchool->id) return response([
            'status' => 'error',
            'status_code' => 501,
            'message' => 'Unauthorized',
        ]);
        $image = '';
        if ($request->has('image') && $request->image != '') {
            $image = '/storage/' . $request->image->store('students/images');
        }

        $updated = $admission->update([
            'school_id' => 1,
            'admission_number' => $request->admission_number,
            'admission_date' => date_format(date_create($request->admission_date), 'Y-m-d'),
            'school_class_id' => $request->class,
            'school_section_id' => $request->section,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'date_of_birth' => date_format(date_create($request->date_of_birth), 'Y-m-d'),
            'gender' => $request->gender,
            'student_category_id' => $request->category,
            'student_house_id' => $request->house,
            'religion' => $request->religion,
            'cast' => $request->caste,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'student_photo' => $image,
            'blood_group' => $request->blood_group,
            'height' => $request->height,
            'weight' => $request->weight,
        ]);
        if ($request->admission_ids && $request->admission_ids != null) {

            foreach ($request->admission_ids as $key => $siblingId) {
                if ($siblingId != '-1') {
                    $sibling = Admission::where('id', $siblingId)->first();
                    if ($sibling->gender === 'male') {
                        $relation = 'brother';
                    } else if ($sibling->gender === 'female') {
                        $relation = 'sister';
                    }
                    $updateSibling = $siblingId->update([
                        'student_id' => $updated->id,
                        'sibling_id' => $siblingId,
                        'relation' => $relation
                    ]);
                    $sibling = Admission::where('id', $updated->id)->first();
                    if ($sibling->gender === 'male') {
                        $relation = 'brother';
                    } else if ($sibling->gender === 'female') {
                        $relation = 'sister';
                    }
                    $siblingUpdate = StudentSibling::create([
                        'student_id' => $siblingId,
                        'sibling_id' => $created->id,
                        'relation' => $relation
                    ]);
                }
            }
        }
         if ($updated) {
            $student_admissions = Admission::where('id', $updated->id)->first();
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'student detail created successfully',
                'student_admission_id' => $student_admissions->id
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create admission',
        ]);


    }
}
