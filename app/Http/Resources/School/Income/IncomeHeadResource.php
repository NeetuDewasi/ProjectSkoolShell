<?php

namespace App\Http\Resources\School\Income;

use Illuminate\Http\Resources\Json\JsonResource;

class IncomeHeadResource extends JsonResource
{
        public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'income_head' => $this->income_head,
            'description' => $this->description,

        ];
    }
}
