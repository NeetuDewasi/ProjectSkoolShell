<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentCategory;
use App\Http\Resources\School\Student\StudentCategoryResource;
use App\Http\Resources\School\Student\CategoryListResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class StudentCategoryController extends Controller
{
    public function getData()
    {
        $studentCategories = StudentCategory::where('school_id', 1)->allowed()->get();
        if (count($studentCategories) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'student_categories' => StudentCategoryResource::collection($studentCategories),
            'message' => ''
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'student_categories' => null,
            'message' => 'No category created yet'
        ]);
    }

    public function getCategory()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if (Session::has('active_school_id') && Session::get('active_school_id') !== -1) {
            $activeSchool = Session::get('active_school');
        }
        $studentCategories = StudentCategory::where('school_id', $activeSchool->id)->allowed()->get();

        if ($studentCategories && count($studentCategories) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => '',
            'category_list' => CategoryListResource::collection($studentCategories),
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'category_list' => null,
            'message' => 'No Category added yet..',
        ]);
    }

    public function updateData(Request $request, StudentCategory $studentCategory)
    {
        $update = $studentCategory->update([
            'name' => $request->category_name,
        ]);

        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Categories  Updated Successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update student category',
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
        $studentCategory = StudentCategory::where('name', $request->category_name)->where('school_id', $activeSchool->id)->first();

        if ($studentCategory) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This category is already exist'
        ]);

        $created = StudentCategory::create([
            'school_id' => $activeSchool->id,
            'name' => $request->category_name,
        ]);

        if ($created) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'category created successfully',
                'student_categories' => new StudentCategoryResource($created),
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create category',
        ]);
    }
    public function changeStatusData(Request $request, StudentCategory $studentCategory)
    {
        $updated = $studentCategory->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Category successfully ' . $request->status,
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
