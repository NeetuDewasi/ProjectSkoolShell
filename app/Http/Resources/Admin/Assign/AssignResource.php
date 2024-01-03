<?php

namespace App\Http\Resources\Admin\Assign;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category;
use App\Http\Resources\Admin\Categories\CategoryResource;
class AssignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $menus = null;
        // if ($this->name) {
        //     $menu_ids = explode(',' , json_decode($this->name));
        //     if (count($menu_id) > 0) {
        //         $menu_ids = Category::whereIn('id', $menu_ids)->get();
        //         $menus = CategoryResource::collection($menu_ids);
        //     }
        // }
        return [
            'school_group_id' => $this->school_group_id,
            'school_id' => $this->school_id,
            'module_name' => $this->name,
            // 'menus'=>$menus,
        ];
    }
}
