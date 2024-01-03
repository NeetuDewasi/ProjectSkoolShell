<?php

namespace App\Http\Resources\School\Fees_Collection;

use App\Http\Resources\School\Student\StudentAdmissionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FeePaymentResource extends JsonResource
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
            'fees_id' => $this->id ,
            'fees_admission_id' => new StudentAdmissionResource($this->studentAdmission),
            'fees_master_id' => new FeesMasterResource($this->feesMaster),
            'fees_discount_id' => new FeesDiscountDropDownResource($this->feeDiscount),
            'fees_date' => $this->date,
            'fees_amount' => $this->amount,
            'fees_discount_amount' => $this->discount_amount,
            'fees_fine_amount' => $this->fine_amount,
            'fees_payment_mode' => $this->payment_mode ,
            'fees_description' => $this->description ,
            'fees_status' => $this->fee_status,
        ];
    }
}
