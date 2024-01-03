<?php

namespace App\Http\Resources\School\Library;

use Illuminate\Http\Resources\Json\JsonResource;

class LibraryBookReckDropdownResource extends JsonResource
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
            'name' => $this->reck_name,
            'shelf_count' => $this->shelf_count,
        ];
    }
}
