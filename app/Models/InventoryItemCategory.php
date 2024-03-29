<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'item_category',
        'description'
    ];
}
