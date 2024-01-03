<?php

namespace App\Http\Controllers\Admin\Backend\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\Admin\Categories\CategoryResource;
class CategoryController extends Controller
{
    public function getMenus(){
        $categories = Category::allowed()->get();
        if(count($categories)>0)
            return response([
                'status_code'=>200,
                'status'=>'success',
                'menus'=> CategoryResource::collection($categories),
            ]);
         return response([
            'status' => 'warning',
            'status_code' => 300,
            'menus' => null,
            'message' => 'No category created yet'
        ]);
    }
    public function saveData(Request $request){
        $category = Category::where('name',$request->menu_name)->first();
        if($category)
         return response([
            'status' => 'warning',
            'status_code' => 300,
            'message' => 'This Category is already exist'
        ]);
        $create = Category::create([
            'name' => $request->menu_name,
        ]);
        if($create) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'category created successfully',
                'menu_item' => new CategoryResource($create),
        ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to create category',
        ]);
    
    }
    public function changeStatusData(Request $request, Category $category)
    {
        $updated = $category->update(['status' => $request->status]);
        if ($updated) return response([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Menus data successfully ' . $request->status,
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

