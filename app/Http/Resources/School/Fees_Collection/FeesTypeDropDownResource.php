<?php

namespace App\Http\Resources\School\Fees_Collection;

use Illuminate\Http\Resources\Json\JsonResource;

class FeesTypeDropDownResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->fees_code
        ];
    }
}
