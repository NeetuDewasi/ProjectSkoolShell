<?php

namespace App\Http\Controllers\School\Examinations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\AdmitCard;
use App\Models\Admission;
use App\Http\Resources\School\Examinations\AdmitDropdownResource;
use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Http\Resources\School\Examinations\AdmitCardResource;
use App\Models\SchoolClass;
use App\Models\SchoolSection;

class PrintAdmitCardController extends Controller
{
    public function getTemplateList()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $admit_card = AdmitCard::where('school_id', $activeSchool->id)->active()->get();
        if (count($admit_card) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'template_list' => AdmitDropdownResource::collection($admit_card),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'admit_card_list' => null,
            'message' => 'No Card created yet'
        ]);
    }
    public function getAdmissionData( SchoolSection $schoolSection, SchoolClass $schoolClass)
    {
        $authUser = Auth::user();

        $user = User::find($authUser->id);

        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }

        $students =
            Admission::where('school_id', $activeSchool->id)->with(['schoolClass', 'schoolSection'])->active()->first();
        if ($students) return response([
            'status' => 'success',
            'status_code' => 200,
            'detailList' => new StudentAdmissionResource($students),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'routes' => null,
            'message' => 'No Detail created yet'
        ]);
    }
    public function getGeneratedAdmitCards(Admission $admission, AdmitCard $admitCard)
    {

        return response([
            'status' => 'success',
            'status_code' => 200,
            'student' => new StudentAdmissionResource($admission),
            'admitCardList' => new AdmitCardResource($admitCard),
            'message' => ''
        ]);
    }
}
