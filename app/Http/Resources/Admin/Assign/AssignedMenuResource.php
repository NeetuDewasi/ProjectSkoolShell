<?php

namespace App\Http\Resources\Admin\Assign;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\admin\School\SchoolResource;
class AssignedMenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
    //    $menus = null;
    //     if ($this->name) {
    //         $menu_ids = explode(",", $this->name);
    //         $menu_idss = json_encode($menu_ids);

    //             $menu_id = Category::whereIn('id', $menu_idss)->get();
    //             print_r($menu_id);
                // $menus = CategoryResource::collection($menu_id);


        return [
            'assign_id'=>$this->id,
            'assign_school_group_id' => $this->school_group_id,
            'school_id' => $this->school_id,
            'school'=> new SchoolResource($this->school),
            'module_name' => json_decode($this->name)
        ];
}
}
