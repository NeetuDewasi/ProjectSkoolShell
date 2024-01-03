<?php

namespace App\Http\Resources\School\Expenses;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'expense_id' => $this->id,
            'expense_head' => new ExpenseHeadDropDownResource($this->expenseHead),
            'expense_name' => $this->name,
            'expense_invoice_number' => $this->invoice_no,
            'expense_date' => $this->date,
            'expense_amount' => $this->amount,
            'expense_documents' => $this->documents,
            'expense_description' => $this->description,
            'expense_status' => $this->status,
        ];
    }
}
