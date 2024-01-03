<?php

namespace App\Http\Resources\School\Certificate;

use Illuminate\Http\Resources\Json\JsonResource;

class IdCardDropdownResource extends JsonResource
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
            'value'=>$this->id,
            'name'=>$this->id_card_title,
        ];
    }
}
