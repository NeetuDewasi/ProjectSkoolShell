<?php

namespace App\Http\Resources\Admin\Categories;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\Component\ComponentResource;
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'menu_id'=>$this->id,
            'menu_name'=>$this->name,
            'components'=>ComponentResource::collection($this->components),
            'status'=>$this->status,
        ];
    }
}
