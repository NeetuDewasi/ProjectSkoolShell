<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAddItemStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'inventory_item_category_id',
        'inventory_add_item_id',
        'inventory_supplier_info_id',
        'inventory_item_store_id',
        'quantity',
        'income_date',
        'description',
        'document'

    ];
    protected $primaryKey = 'inventory_item_store_id';
    public function inventoryItemCategory()
    {
        return $this->belongsTo(InventoryItemCategory::class);
    }
    public function inventoryAddItem()
    {
        return $this->belongsTo(InventoryAddItem::class);
    }
    public function inventorySupplierInfo()
    {
        return $this->belongsTo(InventorySupplierInfo::class);
    }
    public function inventoryItemStore()
    {
        return $this->belongsTo(InventoryItemStore::class, 'inventory_item_store_id');
    }
    public function inventoryItemStock()
    {
        return $this->belongsTo(InventoryAddItemStock::class);
    }

}
