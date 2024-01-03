<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddIncomeInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'income_head',
        'item_name',
        'invoice_number',
        'date',
        'amount',
        'document',
        'description'
    ];

  /**
     * Get the user that owns the Expense
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incomeHead(){
        return $this->belongsTo(IncomeHead::class, 'income_head', 'id');
    }
    public function incomeItem(){
        return $this->belongsTo(InventoryAddItem::class, 'item_name', 'id');
    }

}
