<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Student\StudentGuardianResource;
use App\Models\StudentGuardian;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class StudentGuardianController extends Controller
{

    public function saveData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $father_image = '';
        $mother_image = '';
        $guardian_image = '';
        if ($request->has('father_image') && $request->father_image != '') {
            $father_image = '/storage/' . $request->father_image->store('students' . '/' . $request->admission . '/guardian/images');
        }
        if ($request->has('mother_image') && $request->mother_image != '') {
            $mother_image = '/storage/' . $request->mother_image->store('students' . '/' . $request->admission . '/guardian/images');
        }
        if ($request->has('guardian_image') && $request->guardian_image != '') {
            $guardian_image = '/storage/' . $request->guardian_image->store('students' . '/' . $request->admission . '/guardian/images');
        }


        $created = StudentGuardian::create([
            'school_id' => $activeSchool->id,
            'admission_id' => $request->admission,
            'father_first_name' => $request->father_first_name,
            'father_middle_name' => $request->father_middle_name,
            'father_last_name' => $request->father_last_name,
            'father_mobile' => $request->father_mobile,
            'father_alternative_mobile' => $request->father_alternative_mobile,
            'father_occupation' => $request->father_occupation,
            'father_email' => $request->father_email,
            'father_alternate_email' => $request->father_alternate_email,
            'father_photo' => $father_image,
            'mother_first_name' => $request->mother_first_name,
            'mother_middle_name' => $request->mother_middle_name,
            'mother_last_name' => $request->mother_last_name,
            'mother_mobile' => $request->mother_mobile,
            'mother_alternative_mobile' => $request->mother_alternative_mobile,
            'mother_occupation' => $request->mother_occupation,
            'mother_email' => $request->mother_email,
            'mother_alternate_email' => $request->mother_alternate_email,
            'mother_photo' => $mother_image,
            'guardian_first_name' => $request->guardian_first_name,
            'guardian_middle_name' => $request->guardian_middle_name,
            'guardian_last_name' => $request->guardian_last_name,
            'guardian_mobile' => $request->guardian_mobile,
            'guardian_alternative_mobile' => $request->guardian_alternative_mobile,
            'guardian_occupation' => $request->guardian_occupation,
            'guardian_email' => $request->guardian_email,
            'guardian_alternate_email' => $request->guardian_alternate_email,
            'guardian_photo' => $guardian_image,
            'guardian_relation' => $request->guardian_relation,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'location' => $request->location,
            'landmark' => $request->landmark,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'country' => $request->country,
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'guardian detail created successfully',
                'student_guardians' => new StudentGuardianResource($created),

            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create guardian',
        ]);
    }
     public function getEditItemData(StudentGuardian $studentGuardian)
    {
        return dd('iiddd',$studentGuardian);
        return response([
            'status' => 'success',
            'status_code' => 200,
            'edit_guardian' => new StudentGuardianResource($studentGuardian),
            'message' => ''
        ]);
    }
     public function updateData(Request $request, StudentGuardian $studentGuardian)
    {
        $father_image = '';
        $mother_image = '';
        $guardian_image = '';
        if ($request->has('father_image') && $request->father_image != '') {
            $father_image = '/storage/' . $request->father_image->store('students' . '/' . $request->admission . '/guardian/images');
        }
        if ($request->has('mother_image') && $request->mother_image != '') {
            $mother_image = '/storage/' . $request->mother_image->store('students' . '/' . $request->admission . '/guardian/images');
        }
        if ($request->has('guardian_image') && $request->guardian_image != '') {
            $guardian_image = '/storage/' . $request->guardian_image->store('students' . '/' . $request->admission . '/guardian/images');
        }

        $update = $studentGuardian->update([
            'admission_id' => $request->admission,
            'father_first_name' => $request->father_first_name,
            'father_middle_name' => $request->father_middle_name,
            'father_last_name' => $request->father_last_name,
            'father_mobile' => $request->father_mobile,
            'father_alternative_mobile' => $request->father_alternative_mobile,
            'father_occupation' => $request->father_occupation,
            'father_email' => $request->father_email,
            'father_alternate_email' => $request->father_alternate_email,
            'father_photo' => $father_image,
            'mother_first_name' => $request->mother_first_name,
            'mother_middle_name' => $request->mother_middle_name,
            'mother_last_name' => $request->mother_last_name,
            'mother_mobile' => $request->mother_mobile,
            'mother_alternative_mobile' => $request->mother_alternative_mobile,
            'mother_occupation' => $request->mother_occupation,
            'mother_email' => $request->mother_email,
            'mother_alternate_email' => $request->mother_alternate_email,
            'mother_photo' => $mother_image,
            'guardian_first_name' => $request->guardian_first_name,
            'guardian_middle_name' => $request->guardian_middle_name,
            'guardian_last_name' => $request->guardian_last_name,
            'guardian_mobile' => $request->guardian_mobile,
            'guardian_alternative_mobile' => $request->guardian_alternative_mobile,
            'guardian_occupation' => $request->guardian_occupation,
            'guardian_email' => $request->guardian_email,
            'guardian_alternate_email' => $request->guardian_alternate_email,
            'guardian_photo' => $guardian_image,
            'guardian_relation' => $request->guardian_relation,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'location' => $request->location,
            'landmark' => $request->landmark,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'country' => $request->country,
        ]);
    }
}
