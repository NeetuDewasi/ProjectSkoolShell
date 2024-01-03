<?php

namespace App\Http\Controllers\Admin\Backend\Compoonent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MenuComponent;
use App\Http\Resources\Admin\Component\ComponentResource;
use App\Http\Resources\Admin\Categories\CategorySelect2Resource;

class ComponentController extends Controller
{
    public function getMenus(){
        $categories = Category::allowed()->get();
        if(count($categories)>0)
            return response([
                'status_code'=>200,
                'status'=>'success',
                'menus'=> CategorySelect2Resource::collection($categories)
            ]);
         return response([
            'status' => 'warning',
            'status_code' => 300,
            'menus' => null,
            'message' => 'No category created yet'
        ]);
    }
    public function getComponents(){
        $components = MenuComponent::allowed()->get();
        if(count($components)>0)
            return response([
                'status_code'=>200,
                'status'=>'success',
                'components'=> ComponentResource::collection($components)
            ]);
         return response([
            'status' => 'warning',
            'status_code' => 300,
            'menus' => null,
            'message' => 'No category created yet'
        ]);
    }
    public function saveData(Request $request){
        $component = MenuComponent::where('component_name',$request->name)->first();
        if($component) return response([
            'status_code' => 300,
            'status' => 'warning',
            'message' => '!This Component is already exist'
        ]);
        // $path = '';
        // if($request->has('path_name') && $request->path_name != ''){
        //     $path = '/storage/' . $request->path_name->store('certificates/path');
        // }
        $create = MenuComponent::create([
            'category_id' =>$request->category_id,
            'component_name' =>$request->comp_name,
            'path' =>$request->path_name,
        ]);
        $component = MenuComponent::find($create->id);

        if($create) return response([
            'status_code' => 200,
            'status' => 'success',
            'component' =>new ComponentResource($component),
            'message' => 'Component Created Successfully',
        ]);
    }

    public function updateComponent( $id, Request $request){
        $menu_component = MenuComponent::find($id);
        $update = $menu_component->update([
            'category_id' =>$request->category_id,
            'component_name' =>$request->comp_name,
            'path' =>$request->path_name,
        ]);
        if ($update) {
            return response([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Component updated successfully',
        ]);
    }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Something went wrong, unable to update group',
        ]);
    }
    public function menuComponentDelete(MenuComponent $menuComponent, Request $request)
    {
        $menu_component = MenuComponent::find($menuComponent->id);
        $delete = $menu_component->delete();
        if($delete){
            return response([
                'status' => 'success',
                'status_code' => 200,
                'message' => 'Component successfully deleted',
            ]);
        }
        return response([
            'status' => 'error',
            'status_code' => 400,
            'message' => 'Oops!! Something went wrong. Unable to ' . $request->status,
        ]);
    }
}
