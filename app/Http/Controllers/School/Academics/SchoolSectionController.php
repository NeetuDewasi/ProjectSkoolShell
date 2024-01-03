<?php

namespace App\Http\Controllers\School\Academics;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Academics\SchoolSectionResource;
use App\Models\SchoolClass;
use App\Models\SchoolSection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SchoolSectionController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $schoolSections = SchoolSection::where('school_id', $activeSchool->id)->active()->get();

        if (count($schoolSections) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'school_sections' => SchoolSectionResource::collection($schoolSections),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'school_sections' => null,
            'message' => 'No section created yet'
        ]);
    }

    public function updateData(Request $request, SchoolSection $schoolSection)
    {
        $update = $schoolSection->update([
            'name' => $request->name,
        ]);

        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'sections  Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update school section',
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
        $schoolSection = SchoolSection::where('name', $request->name)->where('school_id', $activeSchool->id)->allowed()->first();

        if ($schoolSection) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This section is already exist'
        ]);

        $created = SchoolSection::create([
            'school_id' => $activeSchool->id,
            'name' => $request->name,
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'section created successfully',
                'school_sections' => new SchoolSectionResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create section',
        ]);
    }

    public function changeStatusData(Request $request, SchoolSection $schoolSection)
    {
        $updated = $schoolSection->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Section data successfully ' . $request->status,
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
