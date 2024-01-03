<?php

namespace App\Http\Resources\School\Certificate;

use Illuminate\Http\Resources\Json\JsonResource;

class CertificateDropDownResource extends JsonResource
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
            'name'=>$this->certificate_name,
            'value'=>$this->id,
        ];
    }
}
