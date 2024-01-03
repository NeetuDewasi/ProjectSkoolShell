<?php

namespace App\Http\Resources\School\Academics;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassPeriodsResource extends JsonResource
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
            'period_id' => $this->class_period_id,
            'period_name' => $this->period != null ? $this->period->name : '',
            'period_start' => $this->period != null ? $this->period->start : "",
            'period_end' => $this->period != null ? $this->period->end : "",

        ];
    }
}
