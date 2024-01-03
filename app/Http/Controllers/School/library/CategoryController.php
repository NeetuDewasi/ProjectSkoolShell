<?php

namespace App\Http\Controllers\School\library;

use App\Http\Controllers\Controller;
use App\Http\Resources\School\Library\LibraryBookCategoryResource;
use App\Models\LibraryBookCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function getData()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $categories = LibraryBookCategory::where('school_id', $activeSchool->id)->allowed()->get();
        if(count($categories) > 0) return response([
            'status' => 'success',
            'status_code' => 200,
            'categories' => LibraryBookCategoryResource::collection($categories),
            'message' => '',
        ]);
        return response([
            'status' => 'warning',
            'status_code' => 300,
            'categories' => null,
            'message' => 'No category add yet..',
        ]);
    }

    public function saveData(Request $request)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $category = LibraryBookCategory::where('school_id',$activeSchool->id)->where('name', $request->category_name)->allowed()->first();

        if($category) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'already exists',
        ]);

        $created = LibraryBookCategory::create([
            'school_id' => $activeSchool->id,
            'name' => $request->category_name,
            'status' => 'activated'
        ]);

        if($created) return response([
            'status' => 'success',
            'status_code' => 201,
            'category' => new LibraryBookCategoryResource($created),
            'message' => 'Category created successfully',
        ]);
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong, Unable to save data',
        ]);

    }
    public function updateData(Request $request, LibraryBookCategory $libraryBookCategory)
    {
        $authUser = Auth::user();
        $user = User::find($authUser->id);
        $activeSchool = null;
        if(Session::has('active_school_id') && Session::get('active_school_id') !== -1 ) {
            $activeSchool = Session::get('active_school');
        }
        $category = LibraryBookCategory::where('school_id',$activeSchool->id)->where('id', '!=', $libraryBookCategory->id)->where('name', $request->category_name)->allowed()->first();
        if($category) return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'already exists',
        ]);

        $updated = $libraryBookCategory->update([
            'name' => $request->category_name,
        ]);

        if($updated) {
            $category = LibraryBookCategory::where('id', $libraryBookCategory->id)->allowed()->first();
            return response([
                'status' => 'success',
                'status_code' => 201,
                'category' => new LibraryBookCategoryResource($category),
                'message' => 'Category created successfully',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong, Unable to save data',
        ]);

    }
}
