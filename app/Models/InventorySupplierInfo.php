<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventorySupplierInfo extends Model
{
    use HasFactory;
    protected $fillable=[
        'school_id',
        'supplier_name',
        'email',
        'address',
        'phone',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_email',
        'description',

    ];

    public function items()
    {
        return $this->belongsToMany(InventoryAddItem::class,'inventory_item_supplier','inventory_add_item_id','inventory_supplier_info_id');
    }

    public function stores()
    {
        return $this->belongsToMany(InventoryItemStore::class,'inventory_item_store_supplier','inventory_item_store_id','inventory_supplier_info_id');
    }
}
