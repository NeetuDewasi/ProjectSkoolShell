<?php

namespace App\Http\Resources\School\Front_Office;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorResource extends JsonResource
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
            'visitor_id' => $this->id,
            'visitor_purpose_id' => new PurposeDropDownResource($this->purpose),
            'visitor_name' => $this->name,
            'visitor_phone' => $this->phone,
            'visitor_email' => $this->email,
            'visitor_id_card' => $this->id_card,
            'visitor_no_of_person' => $this->no_of_person,
            'visitor_date' => $this->date,
            'visitor_in_time' => $this->in_time,
            'visitor_out_time' => $this->out_time,
            'visitor_document' => $this->document,
            'visitor_note' => $this->note,
            'visitor_status' => $this->status,
        ];
    }
}
