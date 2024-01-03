<?php

namespace App\Http\Resources\School\Front_Office;

use Illuminate\Http\Resources\Json\JsonResource;

class PostalResource extends JsonResource
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
            'postal_id' => $this->id,
            'postal_from_title' => $this->from_title,
            'postal_to_title' => $this->to_title,
            'postal_ref_no' => $this->ref_no,
            'postal_type' => $this->postal_type,
            'postal_date' => $this->date,
            'postal_document' => $this->document,
            'postal_address' => $this->address,
            'postal_note' => $this->note,
            'postal_status' => $this->status,
        ];
    }
}
