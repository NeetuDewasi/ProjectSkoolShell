<?php

namespace App\Http\Resources\School\Front_Office;

use Illuminate\Http\Resources\Json\JsonResource;

class PhoneCallLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'phone_id' => $this->id,
            'phone_name' => $this->name,
            'phone_phone' => $this->phone,
            'phone_date' => $this->date,
            'phone_next_date' => $this->next_date,
            'phone_call_duration_minute' => $this->call_duration_minute,
            'phone_call_duration_seconds' => $this->call_duration_seconds,
            'phone_call_type' => $this->call_type,
            'phone_description' => $this->description,
            'phone_note' => $this->note,
            'phone_status' => $this->status,
        ];
    }
}
