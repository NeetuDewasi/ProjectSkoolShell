<?php

namespace App\Http\Resources\School\Fees_Collection;

use App\Http\Controllers\School\FeeCollection\FeesPayment;
use App\Http\Resources\School\Common\ClassListResource;
use App\Http\Resources\School\Student\StudentAdmissionResource;
use App\Models\Fee;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Session;

class FeesMasterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $balance = 0;
        $feePayment = null;
        if(Session::has('student_id')){
            $student = Session::get('student_id');
            if($student) {
                $feePayment = Fee::where('fees_master_id', $this->id)->where('admission_id', $student)->first();
            }
        }
        $amount = $this->amount ? (float) $this->amount : 0;
        $paid = 0;
        $discount = 0;
        $fine = 0;
        if($feePayment) {
            $paid = $feePayment->amount ? (float) $feePayment->amount : 0;
            $discount = $feePayment->discount_amount ? (float) $feePayment->discount_amount : 0;
            $fine = $feePayment->fine_amount ? (float) $feePayment->fine_amount : 0;
        }
        $balance = ($amount + $fine) - $discount - $paid;

        $status = 'unpaid';

        if($feePayment) {
            if($balance < 0) {
                $feePayment->update(['fee_status' => 'advance']);
                $status = 'advance';
            }

            if($balance > 0 && $balance < ($amount + $fine) - $discount) {
                $feePayment->update(['fee_status' => 'partial']);
                $status = 'partial';
            }

            if($balance == 0) {
                $feePayment->update(['fee_status' => 'paid']);
                $status = 'paid';
            }
        }

        return  [
            'fees_master_id' => $this->id,
            'fees_master_class' => new ClassListResource($this->schoolClass),
            'fees_master_fees_group' => new FeesGroupDropDownResource($this->feeGroup),
            'fees_master_fees_type' => new FeesTypeDropDownResource($this->feesType),
            'fees_master_due_date' => $this->due_date,
            'fees_master_amount' => $this->amount,
            'fees_master_fine_type' => $this->fine_type,
            // 'fees_master_percentage' => $this->percantage,
            'fees_master_fine_amount' => $this->fine_amount,
            'fees_master_details' => $this->details,
            'fees_id' => $feePayment ? $feePayment->id : null,
            'fees_admission_id' => $feePayment ? new StudentAdmissionResource($feePayment->studentAdmission) : null,
            'fees_discount_id' => $feePayment ? new FeesDiscountResource($feePayment->feeDiscount) : null,
            'fees_date' => $feePayment ? $feePayment->date : null,
            'fees_amount' => $paid,
            'fees_discount_amount' => $discount,
            'fees_fine_amount' => $fine,
            'fees_payment_mode' => $feePayment ? $feePayment->payment_mode : null,
            'fees_description' => $feePayment ? $feePayment->description : null,
            'fees_balance' => $balance,
            'fees_status' => $status,
        ];
    }
}

