<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Common\ClassListResource;
use App\Http\Resources\School\Hostel\HostelResource;
use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Models\Admission;
use App\Models\StudentDetail;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\School\Student\StudentDetailResource;
use App\Models\Hostel;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\SchoolSection;
use App\Models\StudentGuardian;
use App\Models\StudentSibling;
use Illuminate\Support\Facades\Storage;

class StudentDetailController extends Controller
{
    public function getAllStudents()
    {
        $authUser = Auth::user();

        $user = User::find($authUser->id);

        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        dd($activeSchool);
        $student_detail =
            Admission::where('school_id', $activeSchool->id)->with(['schoolClass', 'schoolSection'])->allowed()->get();
        if ($student_detail) return response([
            'status' => 'success',
            'status_code' => 200,
            'detailList' => new StudentAdmissionResource($student_detail),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'routes' => null,
            'message' => 'No Detail created yet'
        ]);
    }
    public function getAdmissionData(Admission $admission,Hostel $hostel)
    {
        $authUser = Auth::user();

        $user = User::find($authUser->id);

        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $student_detail =
            Admission::where('school_id', $activeSchool->id)->where('id', $admission->id)->with(['schoolClass', 'schoolSection'])->allowed()->first();
        if ($student_detail) return response([
            'status' => 'success',
            'status_code' => 200,
            'detailList' => new StudentAdmissionResource($student_detail),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'routes' => null,
            'message' => 'No Detail created yet'
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
        $imagePath = $admission->student_photo;
        if ($request->hasFile('image') && $request->image != null && $request->image != '') {
            if ($admission->student_photo != null) {
                Storage::delete($admission->student_photo);
            }

            $imagePath = $request->image->store('students/images');
        }

        $update = $admission->update([
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
            'religion' => $request->religion,
            'cast' => $request->caste,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'student_photo' => $imagePath,
            'blood_group' => $request->blood_group,
            'height' => $request->height,
            'weight' => $request->weight,
        ]);

        if ($request->admission_ids && $request->admission_ids != null) {
            $studentSibling = StudentSibling::where('sibling_id', $admission->id)->get();
            foreach ($studentSibling as $key => $value) {
                $value->delete();
            }
            $siblingStudent = StudentSibling::where('student_id', $admission->id)->get();
            foreach ($siblingStudent as $key => $value) {
                $value->delete();
            }
            foreach ($request->admission_ids as $key => $siblingId) {
                if ($siblingId != '-1') {
                    $sibling = Admission::where('id', $siblingId)->first();
                    if ($sibling->gender === 'male') {
                        $relation = 'brother';
                    } else if ($sibling->gender === 'female') {
                        $relation = 'sister';
                    }
                    $createSibling = StudentSibling::create([
                        'student_id' => $admission->id,
                        'sibling_id' => $siblingId,
                        'relation' => $relation
                    ]);
                    $sibling = Admission::where('id', $admission->id)->first();
                    if ($sibling->gender === 'male') {
                        $relation = 'brother';
                    } else if ($sibling->gender === 'female') {
                        $relation = 'sister';
                    }
                    $siblingCreate = StudentSibling::create([
                        'student_id' => $siblingId,
                        'sibling_id' => $admission->id,
                        'relation' => $relation
                    ]);
                }
            }
        }

        // $student = StudentSibling::where('student_id', $admission->id)->get();
        // foreach ($student as $key => $value) {
        //     $studentRelation = Admission::where('id', $request->admission_ids[$key])->first();
        //     if ($studentRelation->gender === 'male') {
        //         $relation = 'brother';
        //     } else if ($studentRelation->gender === 'female') {
        //         $relation = 'sister';
        //     }
        //     $updated = $value->update([
        //         'sibling_id' => $request->admission_ids[$key],
        //         'relation' => $relation
        //     ]);
        // }
        // $sibling = StudentSibling::where('sibling_id', $admission->id)->get();
        // foreach ($sibling as $key => $value) {
        //     $studentRelation = Admission::where('id', $request->admission_ids[$key])->first();
        //     if ($studentRelation->gender === 'male') {
        //         $relation = 'brother';
        //     } else if ($studentRelation->gender === 'female') {
        //         $relation = 'sister';
        //     }
        //     $updated = $value->update([
        //         'student_id' => $request->admission_ids[$key],
        //         'relation' => $relation
        //     ]);
        // }

        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Student  Updated Successfully',
                'student_admission_id' => $admission->id
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update student',
        ]);
    }

    public function changeStatusData(Request $request, Admission $admission)
    {
        $updated = $admission->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'data successfully ' . $request->status,
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

    public function getExStudent(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $studentAdmissions = array();

        if ($request->class && $request->class != null && $request->class != '') {
            if ($request->section && $request->section != null && $request->section != '') {

                $studentAdmissions = Admission::where('school_class_id', $request->class)->where('school_section_id', $request->section)->with(['schoolClass', 'schoolSection'])->allowed()->get();
            }
        } else {
            return response([
                'status' => 'warning',
                'status_code' => 300,
                'ex_student' => null,
                'message' => 'No admission created yet'
            ]);
        }

        if (count($studentAdmissions) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'ex_student' => StudentAdmissionResource::collection($studentAdmissions),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'ex_student' => null,
            'message' => 'No admission created yet'
        ]);
    }
}
