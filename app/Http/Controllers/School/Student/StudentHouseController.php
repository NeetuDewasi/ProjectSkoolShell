<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Student\StudentHouseListResource;
use App\Models\StudentHouse;
use Illuminate\Http\Request;

class StudentHouseController extends Controller
{
    public function getData()
    {
        $studentHouses = StudentHouse::where('school_id', 1)->active()->get();
        if (count($studentHouses) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'student_houses' => StudentHouseListResource::collection($studentHouses),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_houses' => null,
            'message' => 'No house created yet'
        ]);
    }

    public function saveData(Request $request)
    {
        $studentHouse = StudentHouse::where('school_id', 1)->where('name', $request->name)->first();

        if ($studentHouse) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This House is already exist'
        ]);

        $created = StudentHouse::create([
            'school_id' => 1,
            'name' => $request->name,
            'description' => $request->description,
        ]);
        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'house created successfully',
                'student_house' => new StudentHouseListResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create house',
        ]);
    }
    public function updateData(Request $request, StudentHouse $studentHouse)
    {
        $update = $studentHouse->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'house  Updated Successfully',
                // 'student_house' => new StudentHouseListResource($update),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update student house',
        ]);
    }
    public function changeStatusData(Request $request, StudentHouse $studentHouse)
    {
        $updated = $studentHouse->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'House data successfully ' . $request->status,
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
