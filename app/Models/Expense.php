<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'school_id',
        'expense_head_id',
        'invoice_no',
        'name',
        'amount',
        'date',
        'description',
        'documents',
        'details',
        'status',
    ];
    /**
     * Get the user that owns the Expense
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expenseHead(){
        return $this->belongsTo(ExpenseHead::class, 'expense_head_id', 'id');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

}
