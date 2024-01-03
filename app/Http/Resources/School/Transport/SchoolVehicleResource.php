<?php

namespace App\Http\Resources\School\Transport;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolVehicleResource extends JsonResource
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
            'vehicle_id' => $this->id,
            'vehicle_no' => $this->vehicle_no,
            'vehicle_registration_no' => $this->registration_no,
            'vehicle_insurance_date' => $this->insurance_date,
            'vehicle_puc_date' => $this->puc_date,
            'vehicle_service_date' => $this->service_date,
            'vehicle_model' => $this->vehicle_model,
            'vehicle_model_year' => $this->model_year,
            'vehicle_note' => $this->note,
        ];
    }
}
