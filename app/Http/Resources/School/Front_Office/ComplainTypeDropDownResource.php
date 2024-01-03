<?php

namespace App\Http\Resources\School\Front_Office;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplainTypeDropDownResource extends JsonResource
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
            'value' => $this->id,
            'name' => $this->title,
        ];
    }
}
