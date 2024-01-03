<?php

namespace App\Http\Resources\Admin\School;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminSchoolDocResource extends JsonResource
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
            'group_id'=>$this->school_group_id,
            'group'=>new SchoolResource($this->schoolGroup),
            'school_name'=>$this->name,
            'documents' => SchoolDocumentResource::collection($this->schoolDocuments)
        ];
    }
}
