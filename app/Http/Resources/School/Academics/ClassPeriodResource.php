<?php

namespace App\Http\Resources\School\Academics;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassPeriodResource extends JsonResource
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
            'period_id' => $this->id,
            'period_name' => $this->name,
            'period_start' => $this->start,
            'period_end' => $this->end
        ];
    }
}
