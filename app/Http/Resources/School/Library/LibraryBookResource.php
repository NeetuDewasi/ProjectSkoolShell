<?php

namespace App\Http\Resources\School\Library;

use Illuminate\Http\Resources\Json\JsonResource;

class LibraryBookResource extends JsonResource
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
            'book_id'=>$this->id,
            'book_category_id'=>$this->category_id,
            'book_reck_id'=>$this->reck_id,
            'book_shelf_number'=>$this->shelf_number,
            'book_code'=>$this->code,
            'book_title'=>$this->title,
            'book_author'=>$this->author,
            'book_cost'=>$this->cost,
            'fine_on_lost'=>$this->fine,
            'inventory_date'=>$this->inventory_date,
            'bookCoverImagePath'=>$this->cover,
            'book_isbn_number' => $this->isbn_number,
            'book_quantity' => $this->quantity,
            'book_publisher' => $this->publisher,
        ];
    }
}
