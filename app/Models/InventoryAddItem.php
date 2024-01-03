<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAddItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'category_id',
        'item_name'

    ];
    public function itemCategory()
    {
        return $this->belongsTo(InventoryItemCategory::class, 'category_id', 'id');
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

    public function suppliers()
    {
        return $this->belongsToMany(InventorySupplierInfo::class, 'inventory_item_supplier', 'inventory_add_item_id', 'inventory_supplier_info_id');
    }

    public function stocks()
    {
        return $this->hasMany(InventoryAddItemStock::class);
    }
    public function remainstocks()
    {
        return $this->hasMany(InventoryIssueItem::class);
    }
}
