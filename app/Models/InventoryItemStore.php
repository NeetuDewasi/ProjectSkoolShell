<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemStore extends Model
{
    use HasFactory;
    protected $fillable=[
        'school_id',
        'item_store',
        'item_stock',
        'description'
    ];
    public function inventoryAddItemStocks()
    {
        return $this->hasMany(InventoryAddItemStock::class, 'inventory_item_store_id');
    }
}
