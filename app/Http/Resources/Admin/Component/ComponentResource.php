<?php

namespace App\Http\Resources\Admin\Component;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\Categories\CateResource;
class ComponentResource extends JsonResource
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
            'component_id'=>$this->id,
            'component_name'=>$this->component_name,
            'path_name'=>$this->path,
            'category_id'=>$this->category_id,
            'category'=>new CateResource($this->category),
        ];
    }
}
