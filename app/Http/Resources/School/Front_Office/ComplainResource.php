<?php

namespace App\Http\Resources\School\Front_Office;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplainResource extends JsonResource
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
            'complain_id' => $this->id,
            'complain_type_id' =>  new ComplainTypeDropDownResource ($this->complainType),
            'complain_source_id' => new SourceDropDownResource($this->source),
            'complain_person' => $this->complain_by,
            'complain_phone' => $this->phone,
            'complain_date' => $this->date,
            'complain_action_by' => $this->action_by,
            'complain_assigned' => $this->assigned,
            'complain_document' => $this->document,
            'complain_description' => $this->description,
            'complain_status' => $this->status,
        ];
    }
}
